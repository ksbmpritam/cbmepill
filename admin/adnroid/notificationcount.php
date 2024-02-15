<?php
   include("db.php");
   if($_POST['userid']!='')
   {
   $response=array();
   $query = "SELECT * FROM `notificationseen` WHERE `status`='0' and `userid`='".$_POST['userid']."'";
   $dept = mysqli_query($con, $query);
   if(mysqli_num_rows($dept)>0){
        $number=mysqli_num_rows($dept);
        
        echo json_encode(array("status"=>"1","result"=>$number));
    }
    else
    {
        echo json_encode(array("status"=>"0","result"=>'0'));
    }
}
else
{
    echo json_encode(array("status"=>"0","result"=>"0"));
}
?>