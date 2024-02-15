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

if($method == 'POST' && $_POST['category_id'] && $_POST['sub_categories_id'] && $_POST['lesson_plan_id'] && $_POST['lesson_plan_content_id']) {
    if($_POST['category_id'] && $_POST['sub_categories_id'] && $_POST['lesson_plan_id'] && $_POST['lesson_plan_content_id']){
        $result = getOneMinuteByCategory($con,$_POST['category_id'],$_POST['sub_categories_id'],$_POST['lesson_plan_id'],$_POST['lesson_plan_content_id']);
        echo json_encode($result);
    }else{
        echo json_encode(array("success" => "false", 'message' => 'Category Id, sub Category Id, lesson plan Id And lesson plan content Id Required'));   
    }
    
} else if($method == 'POST'  && $_POST['id']) {
    if($_POST['id']){
        $result = getOneMinutePaperById($con,$_POST['id']);
        echo json_encode($result);
    }else{
        echo json_encode(array("success" => "false", 'message' => 'Id Required'));   
    }
}else{
    echo json_encode(array("success" => "false", 'message' => 'Invalid method'));
}


function getOneMinuteByCategory($con,$categoryId,$subCategoryId,$lessonPlanId,$lessonPlanContent)
{
    $res = [];
    $sql = "SELECT * FROM one_minute_paper WHERE status = 1 AND category_id=$categoryId AND sub_categories_id=$subCategoryId AND lesson_plan_id=$lessonPlanId AND lesson_plan_content_id  ORDER BY id DESC";
    $result = mysqli_query($con, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_object($result);

            $user_details = "";
            if ($row->user_id) {
                $user_id = $row->user_id;
                $user_query = "SELECT * FROM users WHERE id = $user_id";
                $user_result = mysqli_query($con, $user_query);
                $user_details = mysqli_fetch_object($user_result);
            }
            // Fetch category details
            $category_details = "";
            if ($row->category_id) {
                $category_id = $row->category_id;
                $category_query = "SELECT * FROM tbl_category WHERE cid = $category_id";
                $category_result = mysqli_query($con, $category_query);
                $category_details = mysqli_fetch_object($category_result);
            }

            // Fetch subcategory details
            $sub_category_details = "";
            if ($row->sub_categories_id) {
                $sub_category_id = $row->sub_categories_id;
                $sub_category_query = "SELECT * FROM sub_categories WHERE id = $sub_category_id";
                $sub_category_result = mysqli_query($con, $sub_category_query);
                $sub_category_details = mysqli_fetch_object($sub_category_result);
            }
            
            $lesson_plan_content = "";
            if ($row->id) {
                $lesson_plan_id = $row->id;
                $lesson_plan_query = "SELECT * FROM lesson_plan_content WHERE lesson_plan_id = $lesson_plan_id";
                $lesson_plan_result = mysqli_query($con, $lesson_plan_query);
                $lesson_plan_content = mysqli_fetch_object($lesson_plan_result);
            }
            
            $one_minute_paper_question = [];
            if ($row->id) {
                $one_minute_paper_id = $row->id;
                $one_minute_paper_query = "SELECT * FROM one_minute_paper_question WHERE one_minute_paper_id = $one_minute_paper_id";
                $one_minute_paper_result = mysqli_query($con, $one_minute_paper_query);

                if ($one_minute_paper_result) {
                    $one_minute_paper_question = mysqli_fetch_all($one_minute_paper_result, MYSQLI_ASSOC);
                }
            }

           

    
            $res = [
                "id" => $row->id,
                "title" => $row->title,
                "user_details" => $user_details,
                "category_details" => $category_details,
                "sub_category_details" => $sub_category_details,
                "lesson_plan_content" => $lesson_plan_content,
                "one_minute_paper_question" => $one_minute_paper_question,
                "created_at" => $row->created_at,
                "updated_at" => $row->updated_at
            ];

            return array("success" => "true", 'data' => $res);
        } else {
            return array("success" => "false", 'data' => $res, 'message' => ' not found');
        }
    } else {
        // Handle SQL query execution error
        return array("success" => "false", 'error' => mysqli_error($con));
    }
}



function getOneMinutePaperById($con, $one_minute_paper_id)
{
    $res = [];
    $sql = "SELECT * FROM one_minute_paper WHERE id = $one_minute_paper_id AND status = 1";
    $result = mysqli_query($con, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_object($result);

            $user_details = "";
            if ($row->user_id) {
                $user_id = $row->user_id;
                $user_query = "SELECT * FROM users WHERE id = $user_id";
                $user_result = mysqli_query($con, $user_query);
                $user_details = mysqli_fetch_object($user_result);
            }
            // Fetch category details
            $category_details = "";
            if ($row->category_id) {
                $category_id = $row->category_id;
                $category_query = "SELECT * FROM tbl_category WHERE cid = $category_id";
                $category_result = mysqli_query($con, $category_query);
                $category_details = mysqli_fetch_object($category_result);
            }

            // Fetch subcategory details
            $sub_category_details = "";
            if ($row->sub_categories_id) {
                $sub_category_id = $row->sub_categories_id;
                $sub_category_query = "SELECT * FROM sub_categories WHERE id = $sub_category_id";
                $sub_category_result = mysqli_query($con, $sub_category_query);
                $sub_category_details = mysqli_fetch_object($sub_category_result);
            }
            
            $lesson_plan_content = "";
            if ($row->id) {
                $lesson_plan_id = $row->id;
                $lesson_plan_query = "SELECT * FROM lesson_plan_content WHERE lesson_plan_id = $lesson_plan_id";
                $lesson_plan_result = mysqli_query($con, $lesson_plan_query);
                $lesson_plan_content = mysqli_fetch_object($lesson_plan_result);
            }
            
            $one_minute_paper_question = [];
            if ($row->id) {
                $one_minute_paper_id = $row->id;
                $one_minute_paper_query = "SELECT * FROM one_minute_paper_question WHERE one_minute_paper_id = $one_minute_paper_id";
                $one_minute_paper_result = mysqli_query($con, $one_minute_paper_query);

                if ($one_minute_paper_result) {
                    $one_minute_paper_question = mysqli_fetch_all($one_minute_paper_result, MYSQLI_ASSOC);
                }
            }

           

    
            $res = [
                "id" => $row->id,
                "title" => $row->title,
                "user_details" => $user_details,
                "category_details" => $category_details,
                "sub_category_details" => $sub_category_details,
                "lesson_plan_content" => $lesson_plan_content,
                "one_minute_paper_question" => $one_minute_paper_question,
                "created_at" => $row->created_at,
                "updated_at" => $row->updated_at
            ];

            return array("success" => "true", 'data' => $res);
        } else {
            return array("success" => "false", 'data' => $res, 'message' => ' not found');
        }
    } else {
        // Handle SQL query execution error
        return array("success" => "false", 'error' => mysqli_error($con));
    }
}
