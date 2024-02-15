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
$currentDateTime = date('Y-m-d  00:00:00');
$tocurrentDateTime = date('Y-m-d  12:00:00');



if($method=='POST')
{
    
    $res=[];
    $query = "
    SELECT u.id, u.profile_pic_url, u.display_name, COUNT(md.mcq_id) as rightAns FROM users u JOIN mcq_data md ON u.id = md.user_id WHERE md.answer = 1 AND md.timestamp BETWEEN '$currentDateTime' AND '$tocurrentDateTime' GROUP BY u.id, u.profile_pic_url, u.display_name ORDER BY rightAns DESC LIMIT 10";
    
   
    $result = mysqli_query($con, $query);
  
   if(mysqli_num_rows($result)>0){
       
       while($row = mysqli_fetch_assoc($result)){
            $res[] = $row;
       }
       
        echo json_encode(array('data'=>$res));

      }
   else{
    echo json_encode(array("success" => "false",'data'=>"no data found.."));


   }
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}

