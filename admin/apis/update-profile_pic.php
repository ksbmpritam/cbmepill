<?php
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, UPDATE");
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../jwt/vendor/autoload.php";
include("../adnroid/db.php");
include("../includes/function.php");

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
$method = $_SERVER['REQUEST_METHOD'];


if($method=='POST')
{
    $secret_key = "MillerJumaWilliam";
    $jwt = null;
  
    
    
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    
    $arr = explode(" ", $authHeader);
    
    
    /*echo json_encode(array(
        "message" => "sd" .$arr[1]
    ));*/
    
    $jwt = $arr[1];
    
    if($jwt){
    
        try {
            
          
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
            $user_id = $decoded->data->user_id;
            $row = getUserdetail($user_id);
            if($row)
            {
               

                 // Set image placement folder
                 if($_FILES['profile_pic_url'])
                 {
                    $target_dir = "../uploads/";
                    $profile_pic_url = uniqid().basename($_FILES["profile_pic_url"]["name"]); 
                    move_uploaded_file($_FILES["profile_pic_url"]["tmp_name"], $target_dir.$profile_pic_url);
                    $profile_pic_url = url()."/uploads/".$profile_pic_url;
                 }
         
        

              $sql = "UPDATE users SET profile_pic_url='$profile_pic_url' WHERE id='$user_id'";

                if (mysqli_query($con, $sql)) {
                  
                  echo json_encode(
                    array(
                        "message" => "update successfully",
                        "success" => "true",
                        "data"=>getUserdetail($user_id)
                    ));
                } else {
                    echo json_encode(array("success" => "false",'message'=>$con->error));
                }
            }
           
    
        }catch (Exception $e){
    
     
        echo json_encode(array("success" => "false",'message'=>$e->getMessage()));
    }
    
    }
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}

