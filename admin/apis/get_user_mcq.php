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
    
    $user_id = $_POST['user'];
  
    $response=[];
  
    $sql = "SELECT tc.category_name,sc.name,tc.cid,sc.id,md.user_id FROM mcq_data md JOIN mcq m JOIN tbl_category tc JOIN sub_categories sc
                                WHERE md.mcq_id=m.id AND m.c_id=tc.cid AND m.sc_id=sc.id AND md.user_id='$user_id' GROUP BY m.sc_id";
         

      $query = mysqli_query($mysqli,$sql);
      
    
    $response["data"] = mysqli_fetch_assoc($query);
    echo json_encode($response);
}    
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}