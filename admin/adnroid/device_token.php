<?php
     include("db.php");
    $response = array();
	
      if (!isset($_POST['device_token']) || !isset($_POST['user_id'])  )  {
			$response["success"] = 0;
			$response["message"] = "Validation errora";
			echo json_encode($response);
		    exit();
          
      }
 
        $device_token   = $_POST['device_token'];   
        $userid   = $_POST['user_id'];   
        
        $check_sql = "select * from  user where `user_id` ='$userid'";
        $check_qry = mysqli_query($con,$check_sql);
        $exist_data = mysqli_fetch_assoc($check_qry);  
		if (empty($exist_data))
		{
			$response["success"] = 0;
			$response["message"] = "User not found";
			echo json_encode($response);
		    exit();
		    
		} 
        else
        {
            $sql="UPDATE `user` SET `device_token`= '".$device_token."' where `user_id`= $userid ";
            $result = mysqli_query($con,$sql)or die( "e");
             if(mysqli_affected_rows($con)){
			$response["success"] = 1;
			$response["message"] = "successfully.";
			//$response["data"]=$row;
			echo json_encode($response);
			exit();
             }else{
            $response["success"] = 1;
			$response["message"] = "no any record update.";
			//$response["data"]=$row;
			echo json_encode($response);
			exit();
             }
		} 
	
?>