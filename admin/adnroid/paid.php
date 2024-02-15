<?php
include("db.php");
if($_POST['subject_id']!='' && $_POST['subject_id']!='' && $_POST['user_id']!='')
{
    
      $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
 	  $row=mysqli_fetch_assoc($query);
 	  $type=explode(' ',$row['type']);
      $csid=explode(' ',$row['csid']);
      $subid=explode(',',$row['subid']);
      $i=0;
      $array=array();
      foreach($subid as $val)
      {
       if($val==$_POST['course_id'])
       {
         $array[]=$i; 
        }
        $i++;
       }
       $csid1=explode(',',$csid[$array[0]]);
       
       $newarray=array();
                $i=0;
                foreach($csid1 as $new)
                {
                    if($new==$_POST['subject_id'])
                    {
                        $newarray[]=$i;
                    }
                    $i++;
                }
 	   $type1=explode('*',$type[$array[0]]);
 	   
 	   $type2=explode(',',$type1[$newarray[0]]);
 	   $data=array();
 	   
 	   foreach($type2 as $val)
 	   {
 	       $data[]=$val;
 	   }
 	   
 	   if(in_array('1',$data))
 	   {
 	       $video='1';
 	   }
 	   else
 	   {
 	       $video='0';
 	   }
 	   if(in_array('2',$data))
 	   {
 	       $pdf='1';
 	   }
 	   else
 	   {
 	       $pdf='0';
 	   }
 	   if(in_array('3',$data))
 	   {
 	       $mcq='1';
 	   }
 	   else
 	   {
 	       $mcq='0';
 	   }
 	   echo json_encode(array("status"=>"1","video"=>$video,"pdf"=>$pdf,"mcq"=>$mcq));
 	  
}
else
{
    echo json_encode(array("status"=>"0","data"=>"Fell All Field"));
}
?>