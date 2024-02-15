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

    $response = [];

    $query = "SELECT * FROM `mcq` WHERE c_id='$cat_id' AND sc_id='$sub_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {

        $res = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $r = [];
            $r["timing"] = $row['timer'];
            $r["title"] = $row['title_text'];

            if (empty($row['title_img'])) {
                $r['title_image'] = false;
            } else {
                $r['title_image'] = "https://chillwithpill.com/chillwithpill-admin/mcq_images/" . $row['title_img'];
            }

            $options = explode("|", $row['options']);

            // $ext = substr($options[0],strlen($options[0])-3,strlen($options[0]));
            $ext = end(explode(".", $options[0]));

            if ($ext == "png" || $ext == "jpg" || $ext == "jpeg") {
                $ro = [];
                foreach ($options as $v) {
                    array_push($ro, "http://cbmepill.com/chillwithpill-admin/mcq_images/" . $v);
                }
                $r['image_options'] = $ro;
                $r['text_options'] = false;
            } else {
                $ro = [];
                foreach ($options as $v) {
                    array_push($ro, $v);
                }
                $r['text_options'] = $ro;
                $r['image_options'] = false;
            }

            $r["correct_option"] = $row['right_option'];
            $r['mcq_id'] = $row['id'];

            array_push($res, $r);
        }

        $response["questions"] = $res;
        echo json_encode($response);
    } else {
        echo json_encode(array("success" => "false", 'message' => 'no mcq available'));
    }
} else {
    echo json_encode(array("success" => "false", 'message' => 'invalid method'));
}
