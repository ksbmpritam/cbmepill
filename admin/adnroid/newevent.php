<?php
   include("db.php");
   if($_POST['token']=='vickybabu')
   {
   $response=array();
   $query = "SELECT * from newevent order by id desc";
   $dept = mysqli_query($con, $query);
if(mysqli_num_rows($dept)>0){
    while ($row = mysqli_fetch_assoc($dept))
    {
        $query1 = "SELECT concat('http://angirasuratgarhlive.com/ksbmadmin/images/event/',image) as image from neweventgallery where eventid='".$row['id']."'";
        $dept1 = mysqli_query($con, $query1);
        
         while($row1 = mysqli_fetch_assoc($dept1))
        {
            $row['images'][]=$row1;
        }    
        
        
        
        $response[]=$row;
        
    }
}

echo json_encode(array("status"=>"1","result"=>$response));
}
else
{
    echo json_encode(array("status"=>"0","Response"=>"Something Wrong"));
}
?>