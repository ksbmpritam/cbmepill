<?php 
    include'db.php';
    //print_r($_REQUEST);
    if($_POST['p_id']!='' && $_POST['amount']!='' && $_POST['subject_id']!='' && $_POST['course_id']!='' && $_POST['type']!='' && $_POST['user_id']!='' && $_POST['data']!='')
    {
        $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
        {
         while($row=mysqli_fetch_assoc($query))
 	     {
 	         echo "<pre>";
 	         print_r($row);
 	         echo "</pre>";
 	      //print_r($row['user_id']);
 	      
 	     
     	        
     	  if($row['csid'] == '' && $row['subid'] == ''){
     	     
     	      if(count(explode(',',$_POST['subject_id'])) == 1){
     	          $subject_string = '';
     	          $getAllSubject = mysqli_query($con,"select * from subject where course_id='".$_POST['course_id']."'");
     	          while($sub_row=mysqli_fetch_assoc($getAllSubject))
                  {
                    $getSum = array_sum(explode(',',$sub_row['amount']));
                    $total_amount += $getSum;
                    $subject_string = $subject_string.','.$sub_row['id'];
     	              
                  }
                  
     	         if($_POST['type'] == 1 || $_POST['type'] == 4)
     	         {
     	             
     	             $getCount = count(explode(',',$subject_string))-2;
     	             $t = '';
     	             for($i=0; $i<=$getCount; $i++){
     	               $t = $t.'*'.'1,2,3';
     	             }
     	             $csid_string = trim($t,"*");
     	             $subStr = trim($subject_string,',');
     	             $updateCourseBuy = mysqli_query($con,"UPDATE user SET paid='1',subid='$subStr', type='".$csid_string."',csid='".$_POST['course_id']."' WHERE user_id='".$row['user_id']."'");
     	          }
     	          
     	          
     	           if($_POST['type'] == 2)
         	         {
         	             $getCount = count(explode(',',$subject_string))-2;
         	             $t = '';
         	             for($i=0; $i<=$getCount; $i++){
         	               $t = $t.'*'.'3';
         	             }
         	             $csid_string = trim($t,"*");
         	             $updateCourseBuy = mysqli_query($con,"UPDATE user SET paid='1',subid='trim($subject_string,',')', type='".$csid_string."',csid='".$_POST['course_id']."' WHERE user_id='".$row['user_id']."'");
         	          }
         	          
         	       if($_POST['type'] == 3)
         	         {
         	             $getCount = count(explode(',',$subject_string))-2;
         	             $t = '';
         	             for($i=0; $i<=$getCount; $i++){
         	               $t = $t.'*'.'1,2';
         	             }
         	             $csid_string = trim($t,"*");
         	             $updateCourseBuy = mysqli_query($con,"UPDATE user SET paid='1',subid='trim($subject_string,',')', type='".$csid_string."',csid='".$_POST['course_id']."' WHERE user_id='".$row['user_id']."'");
         	          }
         	          
         	         if($_POST['type'] == 5)
         	         {
         	             $getCount = count(explode(',',$subject_string))-2;
         	             $t = '';
         	             for($i=0; $i<=$getCount; $i++){
         	               $t = '1,2,3';
         	             }
         	             $csid_string = trim($t,"*");
         	             $updateCourseBuy = mysqli_query($con,"UPDATE user SET paid='1',subid='".$_POST['subject_id']."', type='".$csid_string."',csid='".$_POST['course_id']."' WHERE user_id='".$row['user_id']."'");
         	          }
     	          
     	          
     	      }
     	      
     	  }
 	      
 	     }
 	     
 	    
        }
    }
    else
    {
        echo json_encode(array("status"=>"0","Response"=>"Please Fill All Fields"));
    }
   
?>