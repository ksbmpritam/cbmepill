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

$response = [];

if($method=='POST'){
    $image_id = $_POST['image_id'];
    
    if(isset($image_id) && !empty($image_id)){
        
        $query = "SELECT pill_id FROM `games_pills` WHERE image_id='$image_id'";
        $result = mysqli_query($con, $query);
        
        $r = [];
        while($row = mysqli_fetch_assoc($result)){
            array_push($r,$row['pill_id']);
        }
        
        $response['correct_pill_id'] = $r;
        
        echo json_encode($response);
        
    }else{
        echo json_encode(array("success" => "false",'message'=>'fields not set..'));
    }
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}

