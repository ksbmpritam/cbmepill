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
    $cat_id = $_POST['category_id'];
    $sub_id = $_POST['sub_id'];
    
    $response = [];
    
    $query = "SELECT id as prescription_id,doctor_said as prescription,file,file_type FROM prescription WHERE c_id='$cat_id' AND sc_id='$sub_id'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result)>0){
        
        $res = [];
        
        while($row = mysqli_fetch_assoc($result)){
            $row["file"] = url()."/games_photos/".$row["file"];
            $res[] = $row;            
        }
        
        $response["data"] = $res;
        echo json_encode($response);
        
    }else{
        echo json_encode(array("success" => "false",'message'=>'no prescription available'));
    }
    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}