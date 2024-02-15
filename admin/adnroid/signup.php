<?php
     include("db.php");
    $response = array();
	

	 if (isset($_POST['mobile']) 
	 ) 
        {  
        $mobile   = $_POST['mobile'];   
        $check_sql = "select * from  user where mobile ='$mobile'";
        $check_qry = mysqli_query($con,$check_sql);
        $exist_data = mysqli_fetch_assoc($check_qry);  
		if (!empty($exist_data))
		{
			$response["success"] = 0;
			
			$response["message"] = "Already registered.";
			echo json_encode($response);
		} 
        else
        {
        $name     = $_POST['name'];
        $mobile   = $_POST['mobile'];
        $email    = $_POST['email'];
        $lst_name = $_POST['lst_name'];
        $ed_qual  = $_POST['ed_qualfy'];
        $stream   = $_POST['stream'];
        $country  = $_POST['country'];
        $state    = $_POST['state'];
        $token    = $_POST['token'];

       
          
		 $sql = "insert into user(name,mobile,email,last_name,educ_qual,stream,country,state,token,paid)values ('$name','$mobile','$email','$lst_name','$ed_qual','$stream','$country','$state','$token','0')";
		 $qry = mysqli_query($con,$sql);                  
		
		if ($qry)
		{
		    $result = mysqli_query($con,"select * from  user where mobile ='$mobile'");
            $row = mysqli_fetch_assoc($result);
			$response["success"] = 1;
			$response["message"] = "Registered successfully.";
			$response["data"]=$row;
			echo json_encode($response);
		} 
		else 
		{
			$response["success"] = 0;
			$response["message"] = "Something went wrong";
			echo json_encode($response);
		}
	}}
	else
	{
        $response["success"] = 0;
        $response["message"] = "Please Enter All required fields";
        echo json_encode($response);
    }
?>
