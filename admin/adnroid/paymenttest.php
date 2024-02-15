<?php 
    include'db.php';
    if($_POST['p_id']!='' && $_POST['amount']!='' && $_POST['subject_id']!='' && $_POST['course_id']!='' && $_POST['type']!='' && $_POST['user_id']!='' && $_POST['data']!='')
    {
        $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
 	  while($row=mysqli_fetch_assoc($query))
 	  {
 	      if($row['paid']=='1')
 	      {
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
            if(count($array)=='0')
            {
                $subid=$row['subid'].','.$_POST['course_id'];
                $csid=$row['csid'].' '.$_POST['subject_id'];
                $type=$row['type'].' '.$_POST['type'];
                $query=mysqli_query($con,"update user set subid='$subid',csid='$csid',type='$type' where user_id='".$_POST['user_id']."'");
                if($query)
                {
                    echo json_encode(array("status"=>"1","Response"=>"Data Succeffuly Inserted"));
                }
            }
            else
            {
                $subid[$array[0]];
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
                
                if(in_array($_POST['subject_id'],$csid1))
                {
                    $csid[$array[0]]=$csid[$array[0]];
                }
                else
                {
                    $csid[$array[0]]=$csid[$array[0]].','.$_POST['subject_id'];
                }
                $subid=$row['subid'];
                $csid=implode(' ',$csid);
                
                
                $type1=explode('*',$type[$array[0]]);
                
                $type2=explode(',',$type1[$newarray[0]]);
                
                
                if(in_array($_POST['type'],$type2))
                {
                    $type[$array[0]]=$type[$array[0]];
                }
                else
                {
                    $type[$array[0]]=$type[$array[0]].','.$_POST['type'];
                }
                
                $type=implode(' ',$type);
                $query=mysqli_query($con,"update user set subid='$subid',csid='$csid',type='$type' where user_id='".$_POST['user_id']."'");
                if($query)
                {
                    echo json_encode(array("status"=>"1","Response"=>"Data Succeffuly Inserted"));
                }
            }
            
 	      }
 	      else
 	      {
 	        $query=mysqli_query($con,"update user set paid='1',subid='".$_POST['subject_id']."',csid='".$_POST['course_id']."',type='".$_POST['type']."' where user_id='".$_POST['user_id']."'");
                if($query)
                {
                    echo json_encode(array("status"=>"1","Response"=>"Data Succeffuly Inserted"));
                }
 	      }
 	  }    
    }
    else
    {
        echo json_encode(array("status"=>"0","Response"=>"Please Fill All Fields"));
    }
   
?>