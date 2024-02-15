<?php
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, UPDATE");
header("Access-Control-Allow-Origin: * ");
// header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: text/html; charset=utf-8');

require "../jwt/vendor/autoload.php";
include("../adnroid/db.php");
include("../includes/function.php");

use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];


if ($method == 'POST') {
  $api_data = json_decode(file_get_contents("php://input"));

  //$category_id = $api_data->category_id;
  $category_id = $_POST['category_id'];
  $res = [];
  $sql = "SELECT * FROM sub_categories WHERE category_id='$category_id' ORDER BY order_sc";
  $result = mysqli_query($con, $sql);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_object($result)) {
      $row->sub_category_image = $row->sub_category_image ? url() . '/images/' . $row->sub_category_image : '';
    //   $row->desc = removeHtml(array('<p>', '</p>'), $row->desc);

        $row->desc = strip_tags(html_entity_decode($row->desc));
        $row->desc = preg_replace('/[^a-zA-Z0-9\s]/', '', $row->desc);
        $row->desc = str_replace(["\r", "\n"], ' ', $row->desc);


      $row->newLine = ($row->new_line == null) ? "" : $row->new_line ;
      $res[] = $row;
    }
    echo json_encode(array("success" => "true", 'data' => $res));
  } else {
    echo json_encode(array("success" => "false", 'data' => $res));
  }
} else {
  echo json_encode(array("success" => "false", 'message' => 'invalid method'));
}
