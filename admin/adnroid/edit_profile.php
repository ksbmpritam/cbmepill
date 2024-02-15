<?php
 include("db.php");
    $response = array();
     $sub=array();
		mysqli_set_charset("utf8");
	 if ($_POST['name']!='' && $_POST['last_name']!='' && $_POST['stream']!='' && $_POST['state']!='' && $_POST['email']!='' && $_POST['user_id']!='' && $_POST['educ_qual']) 
        {
$query=mysqli_query($con,'UPDATE `user` SET `name`="'.$_POST['name'].'",`email`="'.$_POST['email'].'",`last_name`="'.$_POST['last_name'].'",`stream`="'.$_POST['stream'].'",`state`="'.$_POST['state'].'",educ_qual="'.$_POST['educ_qual'].'" 
WHERE `user_id`="'.$_POST['user_id'].'"');
            if($query)
            {
                $response["success"] = 1;
			$response["message"] = "Profile Updated Successfully";
            }
            else
            {
                $response["success"] = 0;
			$response["message"] = "Profile Not Updated";
            }
            echo json_encode($response);
        }
	else
	{
        $response["success"] = 0;
        $response["message"] = "Please Enter All login details";
        echo json_encode($response);
    }
?>
