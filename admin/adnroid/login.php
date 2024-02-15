<?php
 include("db.php");
    $response = array();
     $sub=array();
	
	 if (isset($_POST['mobile'])) 
        {  
        $mobile   = $_POST['mobile'];
        $result = mysqli_query($con,"select * from  user where mobile ='$mobile'");
        $row = mysqli_fetch_assoc($result); 
       
      
		if (!empty($row))
		{
			$response["success"] = 1;
			$response["message"] = "Login";
			$response["data"] = $row;
			
			
		
			
			echo json_encode($response);
		} 
		else 
		{
			$response["success"] = 0;
			$response["message"] = "Something went wrong";
			echo json_encode($response);
		}
	}
	else
	{
        $response["success"] = 0;
        $response["message"] = "Please Enter All login details";
        echo json_encode($response);
    }
?>
