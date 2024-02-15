<?php
 include'db.php';
 if($_POST['token']='www' && $_POST['user_id']!=''){
           $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
           if(mysqli_num_rows($query)>0)
           {
               $row=mysqli_fetch_assoc($query);
               $csid=explode(',',$row['csid']);
               $data=array();
               foreach($csid as $id)
               {
                   $query1=mysqli_query($con,"select category_name from tbl_category where cid='".$id."'");
                   $row1=mysqli_fetch_assoc($query1);
                   $data[]=$row1;
               }
               
               echo json_encode(array("status"=>"1","response"=>$row,"course"=>$data));             
           }
           else
           {
               echo json_encode(array("status"=>"0","response"=>"Not Registered"));
           }
 }
 else
 {
     echo json_encode(array("status"=>"0","response"=>"Fill All Field"));
 }
?>