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
    $notification_id = $_POST['notification_id'];
    $user_id = $_POST['user_id'];
    
    if(!isset($user_id) || empty($user_id)){
        die(json_encode(array("success" => "false",'message'=>'user id is required..')));
    }
    
    
    $data = array(
        "user_id" => $user_id,
        "notification_id" => $notification_id,
    );
    
    Insert("notification_data",$data);
    echo json_encode(array("success" => "success",'message'=>'Read Success..'));    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}