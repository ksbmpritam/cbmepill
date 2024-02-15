<?php
 
require_once 'config/DbHandler.php';

//$data = json_decode(file_get_contents("php://input"));
$book_id='';
$user_id='';
$page_no='';
if(isset($_POST['book_id']) && isset($_POST['user_id']) && isset($_POST['page_no']) || isset($_GET['book_id']) && isset($_GET['user_id']) && isset($_GET['page_no']))
{
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $page_no = $_POST['page_no'];
  
    $book_id = $_GET['book_id'];
    $user_id = $_GET['user_id'];
    $page_no = $_GET['page_no'];


$response = array();
$db = new DbHandler();
$res = $db->createBookHistory($book_id, $user_id, $page_no);

if ($res == BOOK_HISTORY_CREATED_SUCCESSFULLY) {
    $response["error"] = false;
    $response["message"] = "Book History Successfully Created!";
    $response["status"]=201;
    echo json_encode($response);
} else if ($res == BOOK_HISTORY_CREATE_FAILED) {
    $response["error"] = true;
    $response["message"] = "Oops! An error occurred while creating Book History";
    $response["status"]=200;
    echo json_encode($response);
} else if ($res == BOOK_HISTORY_ALREADY_EXISTED) {
    $result = $db->updateBookHistory($page_no,$user_id);
    if($result)
    {
            $response["error"] = false;
            $response["message"] = "Book History Update Successfully !";
            $response["status"]=201;
            echo json_encode($response);
    }
    else
    {
            $response["error"] = true;
            $response["message"] = "Oops! An error occurred while updating Book History";
            $response["status"]=200;
            echo json_encode($response);
    }
    
}
}
else
{
    $response["error"] = true;
    $response["message"] = "Oops! Invalid Operation !";
    echo json_encode($response);
    
}


?>