<?php
   include("db.php");
   if($_POST['userid']!='')
   {
       
   $farebase='AAAAq6-fH04:APA91bG7FKq3HJNrjspQbMQhC0NPJaMAypHYzfKRRswUXvB0Cqz4429NI3czWj2BU3G50BkEN5LNklZX9hNRtxs91bO2Kc4gLQtPMGXs-_u1lSjWL1PH2gcqc6SALU5tzxVzcePSd1Cw';
   $response=array();
   $query = "UPDATE `notificationseen` SET `status`='1' where userid='".$_POST['userid']."'";
   $dept = mysqli_query($con, $query);
   if($query)
   {
       echo json_encode(array("status"=>"1","result"=>"Data Updated"));
   }
}
else
{
    echo json_encode(array("status"=>"0","Response"=>"Something Wrong"));
}
?>