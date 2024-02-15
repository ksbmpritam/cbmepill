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

if ($method === 'POST' && !empty($_POST)) {
    $requiredFields = ['student_id', 'teacher_id', 'one_minute_paper_id', 'one_minute_paper_question_id', 'category_id', 'sub_categories_id', 'lesson_plan_id', 'lesson_plan_content_id', 'answer'];

    if (array_diff($requiredFields, array_keys($_POST)) === []) {
        $result = saveAnswer($con, ...array_values($_POST));
        echo $result;
    } else {
        echo json_encode(["success" => false, "message" => "Fields '" . implode("', '", $requiredFields) . "' are required"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid method"]);
}


function saveAnswer($con, ...$params)
{   
    date_default_timezone_set('Asia/Kolkata');
    $formattedDateTime = (new DateTime())->format('Y-m-d H:i:s');
    
    $sql = "INSERT INTO one_minute_paper_answer (student_id, teacher_id, category_id, sub_categories_id, lesson_plan_id, lesson_plan_content_id, one_minute_paper_id, one_minute_paper_question_id, answer, date) 
            VALUES ('" . implode("','", $params) . "', '$formattedDateTime')";
        
    if ($result = mysqli_query($con, $sql)) {
        
        $lastInsertedId = mysqli_insert_id($con);
        
        $ratingQuery = "SELECT * FROM one_minute_paper_answer WHERE id = $lastInsertedId";
        
        if ($ratingResult = mysqli_query($con, $ratingQuery)) {
            return json_encode(["success" => true, "message" => "Answer Save successfully.", "data" => mysqli_fetch_object($ratingResult)]);
        }
    }
    
    return json_encode(["success" => false, "message" => "Error: " . mysqli_error($con)]);
}

