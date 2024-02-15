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


if($method=='POST')
{
    $image_id = $_POST['image_id'];
    $pill_id = $_POST['pill_id'];
    
    $response = [];
    
    $query = "SELECT benefits as text,type FROM `pill_benefits` WHERE image_id='$image_id' AND pill_id='$pill_id'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result)>0){
        
        while($row = mysqli_fetch_assoc($result)){
            $response = $row;
        }
        
        echo json_encode($response);
        
    }else{
        echo json_encode(array("success" => "false",'message'=>'no data available'));
    }
    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}