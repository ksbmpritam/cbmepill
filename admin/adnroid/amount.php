<?php
include("db.php");
if($_POST['subject_id']!='' && $_POST['user_id']!='')
{
      $allamount='0';
      $allmcqamount='0';
      $first=mysqli_fetch_assoc(mysqli_query($con,"select paid from user where user_id='".$_POST['user_id']."'"))['paid'];
      $second=mysqli_fetch_assoc(mysqli_query($con,"select course_id from subject where id='".$_POST['subject_id']."'"))['course_id'];
      if($first=='0')
      {
         $query=mysqli_query($con,"select * from subject where course_id='".$second."'");
         if(mysqli_num_rows($query)>0)
         {
             while($row=mysqli_fetch_assoc($query))
             {
                 $amount=explode(',',$row['amount']);
                 foreach($amount as $am)
                 {
                    $allamount+=$am; 
                 }
                 
                 $i=0;
                 foreach($amount as $am)
                 {
                    if($i==2){
                    $allmcqamount+=$am; 
                    }
                    $i++;
                     
                 }
             }
         }
         echo json_encode(array("status"=>"1","amount"=>$allamount,"mcqamount"=>$allmcqamount));
      }
      else
      {
         /*$query1=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'"); 
         if(mysqli_num_rows($query1)>0)
         {
             $row=mysqli_fetch_assoc($query1);
             $sub=explode(',',$row['subid']);
             if (in_array($_POST['subject_id'], $sub))
             {
               echo "Match found";
             }
            else
            {
              echo "Match not found";
            }
         }*/
         echo json_encode(array("status"=>"1","Response"=>"Under Process")); 
      }
      
}
else
{
    echo json_encode(array("status"=>"0","data"=>"Fell All Field"));
}
?>