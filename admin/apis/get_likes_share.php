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
    
    $p_id = $_POST['prescription_id'];
    $slide_id = $_POST['slide_id'];
    $user_id = $_POST['user_id'];
    
    $response=[];
    
    if(!empty($p_id) xor !empty($slide_id)){
        
        if(!empty($slide_id)){
            
            $check_like_sql = "SELECT count(id) as total FROM slides_like_data WHERE slide_id='$slide_id' AND user_id='$user_id' AND dislike='0'";
            $check_query = mysqli_query($con,$check_like_sql);
            $check_query_row = mysqli_fetch_assoc($check_query);
            if($check_query_row['total'] > 0){
                $response["liked"] = true;
            }else{
                $response["liked"] = false;
            }
            
            $sql = "SELECT likes,share FROM `slides` WHERE id='$slide_id'";
        }else{
            $sql = "SELECT likes,share FROM `prescription` WHERE id='$p_id'";
        }
        
        
        $query = mysqli_query($con,$sql);
        
        while($row = mysqli_fetch_assoc($query)){
            $response["data"] = $row;
        }
        
        echo json_encode($response);
        
    }else{
        echo json_encode(array("success" => "false",'message'=>'invalid data given..'));
    }
  
}    
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}