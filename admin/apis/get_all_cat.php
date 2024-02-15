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

if($method=='GET')
{
    $api_data = json_decode(file_get_contents("php://input"));

    $res=[];
    $sql = "SELECT * FROM tbl_category where status =1 ORDER BY order_c ASC";
    $result = mysqli_query($con, $sql);
   if(mysqli_num_rows($result)>0){
       while($row   = mysqli_fetch_object($result))
       {
        $row->category_image = $row->category_image ? url().'/images/'.$row->category_image: '';
        $row->desc = removeHtml(array('<p>','</p>'),$row->desc);

        $res[] = $row;

       }
    echo json_encode(array("success" => "true",'data'=>$res));

      }
   else{
    echo json_encode(array("success" => "false",'data'=>$res));


   }
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));

}

