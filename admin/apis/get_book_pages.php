<?php
 
require_once 'config/DbHandler.php';
if(isset($_POST['book_id']) && isset($_POST['user_id'])  || isset($_GET['book_id']) && isset($_GET['user_id']) )
{
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    
  
    $book_id = $_GET['book_id'];
    $user_id = $_GET['user_id'];

            $response = array();
            $db = new DbHandler();

            // fetching all Book 
            $result = $db->getBookPages($book_id);

            //$response["error"] = false;
            $response["pages"] = array();

            // looping through result and preparing tasks array
            $tmp = array();
            while ($books = $result->fetch_assoc()) {
                
                $tmp["book_id"] = $books["book_id"];
                $tmp["page_no"] = $books["page_no"];
                $tmp["page_type"] = $books["page_type"];
                $tmp["page_image"] = $books["page_image"];
                $tmp["created_date"] = $books["created_date"];
                
               array_push($response["pages"], $tmp);
            }
             $result2 = $db->getLastPage($book_id,$user_id);
            $tmp1=array();
             while ($last_page = $result2->fetch_assoc()) {
                
                $tmp1['last_read_page']=$last_page;
                
             }
             //echo $tmp1['last_read_page']['page_no'];
            if($tmp["page_no"]==$tmp1['last_read_page']['page_no'])
            {
                $response['last_Page'] = $tmp1['last_read_page']['page_no'];
            }
            else
            {
                $response['last_Page'] =0;
            }
            
        $res = $db->getTransactionStatus($book_id, $user_id);

        date_default_timezone_set('Asia/Kolkata');
        $date=date('Y-m-d h:i:s');
        $exp_date=$res['expired_date'];
        if($res['expired_date'] && $exp_date > $date)
        {
            $response["expired"]=0;
        }
        else if($res['expired_date'] && $exp_date < $date)
        {
            $response["expired"]=1;
        }
        else
        {
            $response["expired"]=0;
        }
        
        
        if ($res['transaction_id'] ) {
            //$response["error"] = false;
            //$response["message"] = "Transaction ID is present!";
            $response["transaction_id"]=1;
            //echo json_encode($response);
        } 
        else {
            //$response["error"] = true;
            //$response["message"] = "Oops! An error occurred Transaction ID is not present";
            $response["transaction_id"]=0;
            //echo json_encode($response);
           }
        
        
        
         //echo $last_pages["page_no"];
        echo json_encode($response);

}
else
{
    $response["error"] = true;
    $response["message"] = "Oops! Invalid Operation !";
    echo json_encode($response);
    
}
?>