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
    $user_id = $_POST['user_id'];
    
    $sql = "SELECT date FROM `users` WHERE id='$user_id'";
    $query = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($query);
    $user_signup_date_time = $row['date'];
    
    
    $res=[];
    // $query = "SELECT n.id,n.title,n.discription,n.url,n.image,n.create_date_time,nd.n_read as rread FROM notification n 
    // LEFT JOIN notification_data nd ON n.id=nd.notification_id AND nd.user_id='$user_id' AND n.date > '$user_signup_date_time' GROUP BY n.id";
    
    // $query = "select * from notification WHERE date > '$user_signup_date_time'";
    $query = "select n.*,nd.n_read from notification n LEFT JOIN notification_data nd ON n.id=nd.notification_id WHERE n.date > '$user_signup_date_time'";
    
    $result = mysqli_query($con, $query);
  
   if(mysqli_num_rows($result)>0){
       
       while($row = mysqli_fetch_assoc($result)){
           
          if($row['n_read'] == 1){
              $row['n_read'] = true;
          }else{
              $row['n_read'] = false;
          }
           
            $res[] = $row;
       }
       
        echo json_encode(array("success" => "true",'data'=>$res));

      }else{
        echo json_encode(array("success" => "false",'data'=>$res));
   }
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}
