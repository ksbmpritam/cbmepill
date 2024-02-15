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
    $user_id = filter($_POST['user_id']);
    $mcq_id = filter($_POST['mcq_id']);
    $answer = filter($_POST['answer']);
    $selected = filter($_POST['selected']);
    
    if($answer == "1" || $answer == "0" || $answer == "-1"){
        
        $response = [];
        
        if(isset($user_id) && isset($mcq_id) && !empty($user_id) && !empty($mcq_id)){
            
            $data = array(
                "user_id" => $user_id,
                "mcq_id" => $mcq_id,
                "answer" => $answer,
                "selected" => $selected,
            );
            
            Insert("mcq_data",$data);
            echo json_encode(array("success" => "true",'message'=>'Answer recored success')); 
            
        }else{
            echo json_encode(array("success" => "false",'message'=>'all fields are required'));
        }
        
    }else{
        echo json_encode(array("success" => "false",'message'=>'answer should be 1,-1 or 0'));
    }
    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}