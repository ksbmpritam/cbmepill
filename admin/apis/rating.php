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

if($method == 'POST' && $_POST) {
    if (
        isset($_POST['student_id']) && isset($_POST['teacher_id']) && isset($_POST['clear']) && isset($_POST['interesting']) &&
        isset($_POST['easy_to_take_notes_from']) && isset($_POST['well_organised']) &&
        isset($_POST['relevant_to_the_course'])  && isset($_POST['category_id']) && isset($_POST['sub_categories_id']) && isset($_POST['lesson_plan_id']) && isset($_POST['lesson_plan_content_id'])
    ) {
        $result = sendRating(
            $con,
            $_POST['student_id'],
            $_POST['teacher_id'],
            $_POST['category_id'],
            $_POST['sub_categories_id'],
            $_POST['lesson_plan_id'],
            $_POST['lesson_plan_content_id'],
            $_POST['clear'],
            $_POST['interesting'],
            $_POST['easy_to_take_notes_from'],
            $_POST['well_organised'],
            $_POST['relevant_to_the_course']
        );

        echo $result;
    } else {
        echo json_encode(array("success" => false, 'message' => 'student_id,category_id,sub_categories_id,lesson_plan_id,lesson_plan_content_id   clear , interesting , easy_to_take_notes_from ,well_organised,relevant_to_the_course  fields are required'));
    }
    
}else{
    echo json_encode(array("success" => "false", 'message' => 'Invalid method'));
}


function sendRating($con, $student_id,$teacher_id,$category_id,$sub_categories_id,$lesson_plan_id,$lesson_plan_content_id, $clear, $interesting, $easyToNotes, $wellOrganised, $relevantToTheCource)
{
    $sql = "INSERT INTO rating (student_id,teacher_id,category_id,sub_categories_id,lesson_plan_id,lesson_plan_content_id, clear, interesting, easy_to_take_notes_from, well_organised, relevant_to_the_course, date) 
            VALUES ('$student_id','$teacher_id','$category_id','$sub_categories_id','$lesson_plan_id','$lesson_plan_content_id', '$clear', '$interesting', '$easyToNotes', '$wellOrganised', '$relevantToTheCource', CURDATE())";

    $result = mysqli_query($con, $sql);

    if ($result) {
        $lastInsertedId = mysqli_insert_id($con);
        $ratingQuery = "SELECT * FROM rating WHERE id = $lastInsertedId";
        $ratingResult = mysqli_query($con, $ratingQuery);
        
        if ($ratingResult && mysqli_num_rows($ratingResult) > 0) {
            $ratingData = mysqli_fetch_object($ratingResult);
            return json_encode(array("success" => true, "message" => "Record inserted successfully.", "data" => $ratingData));
        } else {
            return json_encode(array("success" => false, "message" => "Error fetching inserted record."));
        }
    } else {
        $error = mysqli_error($con);
        return json_encode(array("success" => false, "message" => "Error: " . $error));
    }
}


