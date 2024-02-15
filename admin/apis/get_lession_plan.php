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

if($method == 'POST' && $_POST['id']) {
    if($_POST['id']){
        $result = getLessonPlanById($con,$_POST['id']);
        echo json_encode($result);
    }else{
        echo json_encode(array("success" => "false", 'message' => 'Id Required'));   
    }
} else if($method == 'POST') {
    
    if($_POST['category_id'] && $_POST['sub_categories_id']){
        $result = getLessonPlansByCategory($con,$_POST['category_id'],$_POST['sub_categories_id']);
        echo json_encode($result);
    }else{
        echo json_encode(array("success" => "false", 'message' => 'Category Id and Sub Category Id Required'));   
    }
}else{
    echo json_encode(array("success" => "false", 'message' => 'Invalid method'));
}


function getLessonPlansByCategory($con,$category_id,$sub_category_id)
{
    $res = [];
    $sql = "SELECT * FROM lesson_plan WHERE status = 1 AND category_id= $category_id AND sub_categories_id=$sub_category_id";
    $result = mysqli_query($con, $sql);
    
    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_object($result);

            // Fetch user details
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

            $lesson_plan_content = [];
            if ($row->id) {
                $lesson_plan_id = $row->id;
                $lesson_plan_query = "SELECT * FROM lesson_plan_content WHERE lesson_plan_id = $lesson_plan_id";
                $lesson_plan_result = mysqli_query($con, $lesson_plan_query);

                if ($lesson_plan_result) {
                    $lesson_plan_content = mysqli_fetch_all($lesson_plan_result, MYSQLI_ASSOC);
                }
            }

            $res = [
                "id" => $row->id,
                "topics" => $row->topics,
                "class" => $row->class,
                "duration" => $row->duration,
                "subject" => $row->subject,
                "date" => $row->date,
                "status" => $row->status,
                "teacher_details" => $user_details,
                "category_details" => $category_details,
                "sub_category_details" => $sub_category_details,
                "lesson_plan_content" => $lesson_plan_content,
                "created_at" => $row->created_at,
                "updated_at" => $row->updated_at
            ];

            return array("success" => "true", 'data' => $res);
        } else {
            return array("success" => "false", 'data' => $res, 'message' => 'Lesson plan not found');
        }
    } else {
        // Handle SQL query execution error
        return array("success" => "false", 'error' => mysqli_error($con));
    }
    
    // if ($result) {
    //     if (mysqli_num_rows($result) > 0) {
    //         while ($row = mysqli_fetch_object($result)) {
    //             // Fetch Teacher details
    //             $user_details = "";
    //             if ($row->user_id) {
    //                 $user_id = $row->user_id;
    //                 $user_query = "SELECT * FROM users WHERE id = $user_id";
    //                 $user_result = mysqli_query($con, $user_query);
    //                 $user_details = mysqli_fetch_object($user_result);
    //             }
                
    //             // Fetch category details
    //             $category_details = "";
    //             if ($row->category_id) {
    //                 $category_id = $row->category_id;
    //                 $category_query = "SELECT * FROM tbl_category WHERE cid = $category_id";
    //                 $category_result = mysqli_query($con, $category_query);
    //                 $category_details = mysqli_fetch_object($category_result);
    //             }
                
    //             // Fetch subcategory details
    //             $sub_category_details = "";
    //             if ($row->sub_categories_id) {
    //                 $sub_category_id = $row->sub_categories_id;
    //                 $sub_category_query = "SELECT * FROM sub_categories WHERE id = $sub_category_id";
    //                 $sub_category_result = mysqli_query($con, $sub_category_query);
    //                 $sub_category_details = mysqli_fetch_object($sub_category_result);
    //             }

    //             $lesson_plan_content = [];
    //             if ($row->id) {
    //                 $lesson_plan_id = $row->id;
    //                 $lesson_plan_query = "SELECT * FROM lesson_plan_content WHERE lesson_plan_id = $lesson_plan_id";
    //                 $lesson_plan_result = mysqli_query($con, $lesson_plan_query);

    //                 if ($lesson_plan_result) {
    //                     $lesson_plan_content = mysqli_fetch_all($lesson_plan_result, MYSQLI_ASSOC);
    //                 }
    //             }

    //             $res[] = [
    //                 "id" => $row->id,
    //                 "topics" => $row->topics,
    //                 "class" => $row->class,
    //                 "duration" => $row->duration,
    //                 "subject" => $row->subject,
    //                 "date" => $row->date,
    //                 "status" => $row->status,
    //                 "teacher_details" => $user_details,
    //                 "category_details" => $category_details,
    //                 "sub_category_details" => $sub_category_details,
    //                 "lesson_plan_content" => $lesson_plan_content,
    //                 "created_at" => $row->created_at,
    //                 "updated_at" => $row->updated_at
    //             ];
    //         }

    //         return array("success" => "true", 'data' => $res);
    //     } else {
    //         return array("success" => "false", 'data' => $res);
    //     }
    // } else {
    //     // Handle SQL query execution error
    //     return array("success" => "false", 'error' => mysqli_error($con));
    // }
}



function getLessonPlanById($con, $lesson_plan_id)
{
    $res = [];
    $sql = "SELECT * FROM lesson_plan WHERE id = $lesson_plan_id AND status = 1";
    $result = mysqli_query($con, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_object($result);

            // Fetch user details
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

            $lesson_plan_content = [];
            if ($row->id) {
                $lesson_plan_id = $row->id;
                $lesson_plan_query = "SELECT * FROM lesson_plan_content WHERE lesson_plan_id = $lesson_plan_id";
                $lesson_plan_result = mysqli_query($con, $lesson_plan_query);

                if ($lesson_plan_result) {
                    $lesson_plan_content = mysqli_fetch_all($lesson_plan_result, MYSQLI_ASSOC);
                }
            }

            $res = [
                "id" => $row->id,
                "topics" => $row->topics,
                "class" => $row->class,
                "duration" => $row->duration,
                "subject" => $row->subject,
                "date" => $row->date,
                "status" => $row->status,
                "teacher_details" => $user_details,
                "category_details" => $category_details,
                "sub_category_details" => $sub_category_details,
                "lesson_plan_content" => $lesson_plan_content,
                "created_at" => $row->created_at,
                "updated_at" => $row->updated_at
            ];

            return array("success" => "true", 'data' => $res);
        } else {
            return array("success" => "false", 'data' => $res, 'message' => 'Lesson plan not found');
        }
    } else {
        // Handle SQL query execution error
        return array("success" => "false", 'error' => mysqli_error($con));
    }
}
