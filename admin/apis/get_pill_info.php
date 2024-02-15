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
    
    $pill_id = $_POST['pill_id'];
    $response=[];
  
    // $sql = "SELECT pill_description description,pill_benefits benefits FROM `pills` WHERE id='$pill_id'";
    $sql = "SELECT pill_description description FROM `pills` WHERE id='$pill_id'";
    $query = mysqli_query($con,$sql);
    
    while($row = mysqli_fetch_assoc($query)){
        $response["data"] = $row;
    }
    
    echo json_encode($response);
}    
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}