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


if ($method == 'POST') {
    $cat_id = $_POST['category_id'];
    $sub_id = $_POST['sub_id'];
    $res = [];
    $query = "SELECT id as photo_id,photos as image FROM `game_photos` WHERE c_id='$cat_id' and sc_id='$sub_id' ORDER BY RAND() ";
    
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        
        while ($row = mysqli_fetch_assoc($result)) {
            $row['image'] = "https://cbmepill.com/admin/games_photos/" . $row['image'];
            $res['images'][] = $row;
            
            $img_id = $row['photo_id'];
            
           
            $sql = "SELECT p.id pill_code,p.pill pill,mt.name type,mt.photo FROM `games_pills` gp JOIN pills p JOIN medicine_type mt WHERE gp.pill_id=p.id AND mt.id=p.type AND gp.image_id='$img_id'";

            $re = mysqli_query($con, $sql);
            $r = mysqli_fetch_assoc($re);
            
            // $r['photo'] = url()."/medicines/".$r['photo'];
            
            $res['pills'][] = $r;
        }
        
        // This is adding
        // $res['pills'] = array_unique($res['pills']);
        
        echo json_encode(array("success" => "true", 'data' => $res));
    } else {
        echo json_encode(array("success" => "false", 'data' => $res));
    }
} else {
    echo json_encode(array("success" => "false", 'message' => 'invalid method'));
}

