<?php
   include("db.php");
   if($_POST['token']=='vickybabu' && $_POST['userid']!='' )
   {
       mysqli_set_charset($con,"utf8");
       $response=array();
       $sel=mysqli_query($con,"SELECT * FROM `user` WHERE  `user_id`='".$_POST['userid']."'");
       $dsdd=mysqli_fetch_assoc($sel);
       
       if($dsdd['paid']==1)
       {
         $name="paid_published=1";  
       }
       else
       {
           $name="published=1"; 
       }
        
    $query=mysqli_query($con,"SELECT * FROM `notificationseen` WHERE  `userid`='".$_POST['userid']."' order by id desc");
    if(mysqli_num_rows($query)>0)
    {
       while($row=mysqli_fetch_assoc($query))
        {
            $id=$row['notiification'];
            $farebase='AAAAq6-fH04:APA91bG7FKq3HJNrjspQbMQhC0NPJaMAypHYzfKRRswUXvB0Cqz4429NI3czWj2BU3G50BkEN5LNklZX9hNRtxs91bO2Kc4gLQtPMGXs-_u1lSjWL1PH2gcqc6SALU5tzxVzcePSd1Cw';
            
            $noti=mysqli_query($con,"SELECT id,farebase,title,discription,course_id,subject_id,CONCAT('http://angirasuratgarhlive.com/ksbmadmin/images/notification/',image) as image,published FROM `notification` where id='$id' AND $name");
            if(mysqli_num_rows($noti)>0){
            $row1=mysqli_fetch_assoc($noti);
            $response[]= $row1;
            }
        }
    }

echo json_encode(array("status"=>"1","result"=>$response));
}
else
{
    echo json_encode(array("status"=>"0","Response"=>"Something Wrong"));
}
?>