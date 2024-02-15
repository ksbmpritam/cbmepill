<?php
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, UPDATE");
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../jwt/vendor/autoload.php";
include("../adnroid/db.php");
include("../includes/function.php");

$method = $_SERVER['REQUEST_METHOD'];


if($method=='POST')
{
    $cat_id = $_POST['category_id'];
    $sub_id = $_POST['sub_id'];
    
    $response = [];
    
    $query = "SELECT slide_id FROM slides WHERE c_id='$cat_id' AND sc_id='$sub_id' GROUP BY slide_id ORDER BY orders";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result)>0){
        
        $res = [];
        
        while($row = mysqli_fetch_assoc($result)){
            $slide_id = $row['slide_id'];
            $sql_min = "SELECT id as slide_id,description,image FROM slides WHERE slide_id='$slide_id'";
            $query_min = mysqli_query($con,$sql_min);
            
            if(mysqli_num_rows($query_min) == '1' ){
                while($row_min = mysqli_fetch_assoc($query_min)){
                    if(strpos($row_min['image'],".") > 0){
                        $row_min['image'] = url()."/slides/".$row_min["image"];
                    }else{
                        $row_min['image'] = null;
                    }
                        $res[] = $row_min;            
                }
            }else{
                $sql_minn = "SELECT image FROM slides WHERE slide_id='$slide_id'";
                $query_minn = mysqli_query($con,$sql_minn);
                
                $img_array = [];
                while($row_min = mysqli_fetch_assoc($query_minn)){
                    
                    if(strpos($row_min['image'],".") > 0){
                        $row_min['image'] = url()."/slides/".$row_min["image"];
                    }else{
                        $row_min['image'] = null;
                    }
                    
                    array_push($img_array,$row_min['image']);
                }
                
                $sql_min = "SELECT id as slide_id,description,image FROM slides WHERE slide_id='$slide_id' GROUP BY slide_id";
                $query_min = mysqli_query($con,$sql_min);
                
                while($row_min = mysqli_fetch_assoc($query_min)){
                    $row_min['image'] = $img_array;
                    $res[] = $row_min;            
                }
                
                
            }
                        
            
            
        }
        
        $response["slides"] = $res;
        echo json_encode($response);
        
    }else{
        echo json_encode(array("success" => "false",'message'=>'no slides available'));
    }
    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}