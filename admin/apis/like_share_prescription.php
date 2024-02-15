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

$method = $_SERVER['REQUEST_METHOD'];


if($method=='POST'){
    $prescription_id = $_POST['p_id'];
    $like_share = $_POST['like_share']; // l like, s share
    
    if($like_share == "l"){
        $msg = "liked count success";
        $query = "update prescription set likes=likes+1 WHERE id='$prescription_id'";
    }elseif($like_share == "s"){
        $msg = "share count success";
        $query = "update prescription set share=share+1 WHERE id='$prescription_id'";
    }else{
        die(json_encode(array("success" => "false",'message'=>'invalid operation')));
    }
    
    
    if(mysqli_query($con, $query)){
        echo json_encode(array("success" => "true",'message'=>$msg));
    }else{
        echo json_encode(array("success" => "false",'message'=>'There is some error..'));
    }
    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}