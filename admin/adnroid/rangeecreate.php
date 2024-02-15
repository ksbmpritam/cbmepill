<?php 
   include("db.php");
   $query=mysqli_query($con,"select cid from tbl_category");
   if(mysqli_num_rows($query))
   {
       while($row=mysqli_fetch_assoc($query))
       {
          $query1=mysqli_query($con,"select id,course_id from subject where course_id='".$row['cid']."'");
          if(mysqli_num_rows($query1))
          {
            while($row1=mysqli_fetch_assoc($query1))
            {
                $query2=mysqli_query($con,"SELECT id FROM `exam` WHERE `courseid`='".$row['cid']."' and `subjectid`='".$row1['id']."'");
                 if(mysqli_num_rows($query2))
                   {
                       $i=1;
                      while($row2=mysqli_fetch_assoc($query2))
                     {
                         $query3=mysqli_query($con,"update exam set rangee='$i' where id='".$row2['id']."'");
                         if($query3)
                         {
                             $i++;
                         }
                     }
                   }     
            }
         }      
       }
   }
?>