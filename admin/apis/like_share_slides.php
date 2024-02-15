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
    $slide_id = $_POST['slide_id'];
    $like_share = $_POST['like_share']; // l like, s share
    $user_id = $_POST['user_id'];
    $dis_like = $_POST['dis_like'];
    
    if(!isset($user_id) || empty($user_id)){
        die(json_encode(array("success" => "false",'message'=>'user id is required..')));
    }
    
    if(!isset($dis_like) || empty($dis_like)){
        
        if($like_share == "l"){
            
            $count = "SELECT * FROM `slides_like_data` WHERE slide_id='$slide_id' AND user_id='$user_id' AND dislike='0'";
            $count = mysqli_query($con,$count);
            $count = mysqli_num_rows($count);
            
            if($count > 0){
                die(json_encode(array("success" => "false",'message'=>'you already like..')));
            }
            
            $data = array(
                "slide_id" => $slide_id,
                "user_id" => $user_id,
            );
            
            Insert("slides_like_data",$data);
            
            $delete_sql = "delete from slides_like_data WHERE slide_id='$slide_id' AND user_id='$user_id' AND dislike='1'";
            mysqli_query($con,$delete_sql);
            
            $msg = "liked count success";
            $query = "update slides set likes=likes+1 WHERE id='$slide_id'";
        }elseif($like_share == "s"){
            $msg = "share count success";
            $query = "update slides set share=share+1 WHERE id='$slide_id'";
        }else{
            die(json_encode(array("success" => "false",'message'=>'invalid operation')));
        }
        
        
        if(mysqli_query($con, $query)){
            echo json_encode(array("success" => "true",'message'=>$msg));
        }else{
            echo json_encode(array("success" => "false",'message'=>'There is some error..'));
        }
        
    }else{
        
        $count = "SELECT * FROM `slides_like_data` WHERE slide_id='$slide_id' AND user_id='$user_id' AND dislike='1'";
        $count = mysqli_query($con,$count);
        $count = mysqli_num_rows($count);
        
        if($count > 0){
            die(json_encode(array("success" => "false",'message'=>'you already dislike..')));
        }else{
            
            $data = array(
                "slide_id" => $slide_id,
                "user_id" => $user_id,
                "dislike" => 1,
            );
            
            Insert("slides_like_data",$data);
            
            
            $less_like = "update slides set likes=likes-1 WHERE id='$slide_id'";
            mysqli_query($con, $less_like);
            $delete_sql = "delete from slides_like_data WHERE slide_id='$slide_id' AND user_id='$user_id' AND dislike='0'";
            if(mysqli_query($con,$delete_sql)){
                echo json_encode(array("success" => "true",'message'=>'Dislike success'));
            }
            
        }
        
    }
    
    
}
else{
    echo json_encode(array("success" => "false",'message'=>'invalid method'));
}