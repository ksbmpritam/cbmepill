<?php
 
require_once 'config/DbHandler.php';

//$data = json_decode(file_get_contents("php://input"));
if(isset($_REQUEST['book_id']) && isset($_REQUEST['user_id']) && isset($_REQUEST['transaction_id']))
{
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $transaction_id = $_POST['transaction_id'];
    $amount = $_POST['amount'];
  
 


$response = array();
$db = new DbHandler();
$res = $db->createTransaction($book_id, $user_id, $transaction_id,$amount);
if ($res == OK) {
    $response["error"] = false;
    $response["message"] = "Book Transaction Successfully Created!";
    $response["status"]=1;
    echo json_encode($response);
} 
else {
    $response["error"] = true;
    $response["message"] = "Oops! An error occurred while creating Book Transaction";
    $response["status"]=0;
    echo json_encode($response);
   } 
}
else
{
    $response["error"] = true;
    $response["message"] = "Oops! Invalid Operation !";
    echo json_encode($response);
    
}


?>