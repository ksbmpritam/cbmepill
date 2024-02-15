<?php
 
require_once 'config/DbHandler.php';

// if(isset($_REQUEST['subject_id']) && isset($_REQUEST['coupons_name']) && isset($_REQUEST['amount']) )
// {

  $user_id=$_POST['user_id'];
  $coupons_name=$_POST['coupons_name'];
  $amount=$_POST['amount'];

  if($user_id=='')
  {
      echo json_encode(array("status"=>"false","Response"=>"User_id cannot be blank !"));
  }
  elseif($coupons_name=='')
  {
      echo json_encode(array("status"=>"false","Response"=>"Coupon Name cannot be blank !"));
  }
  elseif($amount=='')
  {
      echo json_encode(array("status"=>"false","Response"=>"Amount cannot be blank !"));
  }
  else
  {
        $response = array();
        $db = new DbHandler();
        
        // verify Coupons 
        $result = $db->verify_coupon($user_id,$coupons_name,$amount);
  }
    

?>