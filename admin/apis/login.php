<?php
date_default_timezone_set('Asia/Kolkata');
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, UPDATE");
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$date = time();

require "../jwt/vendor/autoload.php";
include("../adnroid/db.php");
include("../includes/function.php");

use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];

if($method=='POST')
{
    $api_data = json_decode(file_get_contents("php://input"));

    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $display_name = $_POST['display_name'];
    $profile_pic_url = $_POST['profile_pic_url'];
    $gender = $_POST['gender'];
    $playerScore = $_POST['playerScore'];
    $type = $_POST['type'];
    $device_token = $_POST['device_token'];
    
    #This is added by me
    $sql = "SELECT * FROM `users` WHERE email='$email'";
    $query = mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
        $sql = "UPDATE `users` SET `device_token`='$device_token' WHERE `email`='$email'";
        mysqli_query($con,$sql);
    }
    
    
    
    if($type=='mobile'){
        
    $sql = "SELECT id FROM users WHERE mobile='$mobile' limit 1";
    $result = mysqli_query($con, $sql);
    
       if(mysqli_num_rows($result)>0){
            $row = $result->fetch_assoc();
            $user_id    = $row['id'];
       }
       else{
            $d = date('Y-m-d h:i:s');
            $query = "INSERT INTO users (mobile, status, created_at,device_token,date) VALUES ('$mobile',1,'$d','$device_token','$date')";
            if ($con->query($query) === TRUE) {
              $user_id    = $con->insert_id;
            } else {
                echo json_encode(array("success" => "false",'message'=>$con->error));
            }
    
       }
}
    else{
    $sql = "SELECT id FROM users WHERE email='$email' limit 1";
    $result = mysqli_query($con, $sql);
    
       if(mysqli_num_rows($result)>0){
            $row = $result->fetch_assoc();
            $user_id    = $row['id'];
       }
       else {
        $d = date('Y-m-d h:i:s');
        $query = "INSERT INTO users (email,display_name,gender,profile_pic_url,status,playerScore,created_at,device_token,date)
        VALUES ('$email','$display_name','$gender','$profile_pic_url',1,'$playerScore','$d','$device_token','$date')";
        
            if ($con->query($query) === TRUE) {
                $user_id    = $con->insert_id;
            } else {
                echo json_encode(array("success" => "false",'message'=>$con->error));
            }
       }
}

    if($user_id){
        $secret_key = "MillerJumaWilliam";
        $issuer_claim = "localhost"; 
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // time issued 
        $notbefore_claim = $issuedat_claim + 10; 
        $expire_claim = $issuedat_claim + 31536000; 
    
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "user_id" => $user_id,
                "mobile" => $mobile
        ));
    
        $jwtValue = JWT::encode($token, $secret_key,'HS256');
        echo json_encode(
            array(
                "message" => "success",
                "token" => $jwtValue,
                "expiry" => $expire_claim,
                "data"=>getUserdetail($user_id)
            ));
    
    } 
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}

