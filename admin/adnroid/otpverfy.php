<?php  
include("db.php");
if($_POST['otp']!='' && $_POST['otp1']!='' && $_POST['mobile']!='' && $_POST['token']!='')
{
   $query=mysqli_query($con,"select * from user where mobile='".$_POST['mobile']."'");
   if(mysqli_num_rows($query)>0)
   {
       $row=mysqli_fetch_assoc($query);
       if($row['token']=='')
       {
           if($_POST['otp']==$_POST['otp1'])
           {
               $query1=mysqli_query($con,"update user set token='".$_POST['token']."' where user_id='".$row['user_id']."'");
               if($query1){
                   $query2=mysqli_query($con,"select * from user where mobile='".$_POST['mobile']."'");
                   $row2=mysqli_fetch_assoc($query2);
               echo json_encode(array("status"=>"0","Response"=>"OTP  Match"));
               }
           }
           else
           {
               echo json_encode(array("status"=>"2","Response"=>"OTP  Not Match"));
           }
       }
       elseif($row['token']==$_POST['token'])
       {
           if($_POST['otp']==$_POST['otp1'])
           {
               echo json_encode(array("status"=>"0","Response"=>"OTP  Match"));
           }
           else
           {
               echo json_encode(array("status"=>"2","Response"=>"Otp Not Match"));
           }
       }
       else
       {
           if($_POST['otp']==$_POST['otp1'])
           {
                echo json_encode(array("status"=>"1","Response"=>"User Id Already Used In Another Mobile."));
           }
           else
           {
               echo json_encode(array("status"=>"2","Response"=>"Otp Not Match"));
           }
       }
   }
   else
   {
       
      if($_POST['otp']==$_POST['otp1'])
           {
                echo json_encode(array("status"=>"0"));
           }
           else
           {
               echo json_encode(array("status"=>"2","Response"=>"Otp Not Match"));
           } 
   }
}

else
      {
         			$response["status"] = 1;
			$response["message"] = "OTP  Blank";
			echo json_encode($response); 
      }
?>