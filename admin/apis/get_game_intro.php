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
    
    $cat_id = $_POST['category_id'];
    $sub_id = $_POST['sub_id'];
    $response=[];
  
    $sql = "SELECT slide_id FROM `game_intro` WHERE c_id='$cat_id' AND sc_id='$sub_id' GROUP BY slide_id ORDER BY intro_order ASC";

    $query = mysqli_query($con,$sql);
    
    $res = [];
   
    while($row = mysqli_fetch_assoc($query)){
        
        $slider_id = $row['slide_id']; 
      
      
        $sql1 = "SELECT file,file_type,game_case FROM `game_intro` WHERE slide_id='$slider_id'";
        $query1 = mysqli_query($con,$sql1);
        
        $res_lite = [];
        $r = [];
        
        while($row1 = mysqli_fetch_assoc($query1)){
            $q_array = [];
            
            $row1['file'] = "https://cbmepill.com/admin/games_photos/".$row1['file'];
            
            $q_array["file"] = $row1["file"];
            $q_array["file_type"] = $row1["file_type"];
            
            array_push($r,$q_array);           
            $res_lite["game_case"] = $row1["game_case"];
        }
        $res_lite["files"] = $r;
        
        
        array_push($res,$res_lite);
    }
    
    $response["data"] = $res;
    echo json_encode($response);
}    
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}