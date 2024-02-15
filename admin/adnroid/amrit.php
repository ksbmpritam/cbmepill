<?php
  include("db.php");
  
  if($_POST['p_id']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"Payment Id Blank"));
  }
  elseif($_POST['details']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"details Field Blank"));
  }
  elseif($_POST['cid']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"Course Id Field Blank"));
  }
  elseif($_POST['sid']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"Subject Id Field Blank"));
  }
  elseif($_POST['user_id']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"User Id Field Blank"));
  }
  elseif($_POST['type']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"Type Field Blank"));
  }
  elseif($_POST['amount']=='')
  {
      echo json_encode(array("status"=>"0","Response"=>"amount Field Blank"));
  }
  else
  {
      $_POST['data']=$_POST['details']; 
      if($_POST['type']==1)
      {
          $subid=array();
          $type=array();
          $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
          if(mysqli_num_rows($query)>0)
          {
              $row=mysqli_fetch_assoc($query);
              $query1=mysqli_query($con,"select * from subject where course_id='".$_POST['cid']."'");
              if(mysqli_num_rows($query1)>0)
              {
                  $count=mysqli_num_rows($query1);
                  while($row=mysqli_fetch_assoc($query1))
                  {
                   $subid[]=$row['id'];
                   $type[]='1,2,3'; 
                  }
              }
              $subid=implode(',',$subid);
              $type=implode('*',$type);
              $payment=mysqli_query($con,"INSERT INTO `payment`( `p_id`, `amount`, `subject_id`, `course_id`, `type`, `user_id`, `data`) VALUES ('".$_POST['p_id']."','".$_POST['amount']."','".$_POST['sid']."','".$_POST['cid']."','".$_POST['type']."','".$_POST['user_id']."','".$_POST['data']."')");
              if($payment)
              {
              $final=mysqli_query($con,"update user set paid='1',subid='$subid',type='$type',csid='".$_POST['cid']."' where user_id='".$_POST['user_id']."'");
              echo json_encode(array("status"=>"1","Response"=>"Data Inserted"));
              }
              else
              {
                  echo json_encode(array("status"=>"0","Response"=>"Payment Not Inserted"));
              }
          }
          else
          {
              echo json_encode(array("status"=>"0","Response"=>"User Id Wrong"));
          }
      }
      elseif($_POST['type']==2)
      {
          $subid=array();
          $type=array();
          $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
          if(mysqli_num_rows($query)>0)
          {
              $row=mysqli_fetch_assoc($query);
              $query1=mysqli_query($con,"select * from subject where course_id='".$_POST['cid']."'");
              if(mysqli_num_rows($query1)>0)
              {
                  $count=mysqli_num_rows($query1);
                  while($row=mysqli_fetch_assoc($query1))
                  {
                   $subid[]=$row['id'];
                   $type[]='3'; 
                  }
              }
              $subid=implode(',',$subid);
              $type=implode('*',$type);
              $payment=mysqli_query($con,"INSERT INTO `payment`( `p_id`, `amount`, `subject_id`, `course_id`, `type`, `user_id`, `data`) VALUES ('".$_POST['p_id']."','".$_POST['amount']."','".$_POST['sid']."','".$_POST['cid']."','".$_POST['type']."','".$_POST['user_id']."','".$_POST['data']."')");
              if($payment)
              {
              $final=mysqli_query($con,"update user set paid='1',subid='$subid',type='$type',csid='".$_POST['cid']."' where user_id='".$_POST['user_id']."'");
              echo json_encode(array("status"=>"1","Response"=>"Data Inserted"));
              }
              else
              {
                  echo json_encode(array("status"=>"0","Response"=>"Payment Not Inserted"));
              }
          }
          else
          {
             echo json_encode(array("status"=>"0","Response"=>"User Id Wrong"));
          }
      }
      elseif($_POST['type']==3)
      {
          $subid=array();
          $type=array();
          $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
          if(mysqli_num_rows($query)>0)
          {
              $row=mysqli_fetch_assoc($query);
              $query1=mysqli_query($con,"select * from subject where course_id='".$_POST['cid']."'");
              if(mysqli_num_rows($query1)>0)
              {
                  $count=mysqli_num_rows($query1);
                  while($row=mysqli_fetch_assoc($query1))
                  {
                   $subid[]=$row['id'];
                   $type[]='1,2,3'; 
                  }
              }
              $subid=implode(',',$subid);
              $type=implode('*',$type);
              $payment=mysqli_query($con,"INSERT INTO `payment`( `p_id`, `amount`, `subject_id`, `course_id`, `type`, `user_id`, `data`) VALUES ('".$_POST['p_id']."','".$_POST['amount']."','".$_POST['sid']."','".$_POST['cid']."','".$_POST['type']."','".$_POST['user_id']."','".$_POST['data']."')");
              if($payment)
              {
              $final=mysqli_query($con,"update user set paid='1',subid='$subid',type='$type',csid='".$_POST['cid']."' where user_id='".$_POST['user_id']."'");
              echo json_encode(array("status"=>"1","Response"=>"Data Inserted"));
              }
              else
              {
                  echo json_encode(array("status"=>"0","Response"=>"Payment Not Inserted"));
              }
          }
          else
          {
              echo json_encode(array("status"=>"0","Response"=>"User Id Wrong"));
          }
      }
      elseif($_POST['type']==4)
      {
          $subid1=array();
          $type1=array();
          
          $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
          if(mysqli_num_rows($query)>0)
          {
              $row=mysqli_fetch_assoc($query);
              $subid=$row['subid'];
              $type=$row['type'];
              $csid=$row['csid'];
              $query1=mysqli_query($con,"select * from subject where course_id='".$_POST['cid']."'");
              if(mysqli_num_rows($query1)>0)
              {
                  $count=mysqli_num_rows($query1);
                  while($row1=mysqli_fetch_assoc($query1))
                  {
                   $subid1[]=$row1['id'];
                   $type1[]='1,2,3'; 
                  }
              }
              
              $subid1=implode(',',$subid1);
              $type1=implode('*',$type1);
              $subid2=$subid.' '.$subid1;
              $type2=$type.' '.$type1;
              $csid2=$csid.','.$_POST['cid'];
              $payment=mysqli_query($con,"INSERT INTO `payment`( `p_id`, `amount`, `subject_id`, `course_id`, `type`, `user_id`, `data`) VALUES ('".$_POST['p_id']."','".$_POST['amount']."','".$_POST['sid']."','".$_POST['cid']."','".$_POST['type']."','".$_POST['user_id']."','".$_POST['data']."')");
              if($payment)
              {
              $final=mysqli_query($con,"update user set paid='1',subid='$subid2',type='$type2',csid='".$csid2."' where user_id='".$_POST['user_id']."'");
              echo json_encode(array("status"=>"1","Response"=>"Data Inserted"));
              }
              else
              {
                  echo json_encode(array("status"=>"0","Response"=>"Payment Not Inserted"));
              }
          }
          else
          {
              echo json_encode(array("status"=>"0","Response"=>"User Id Wrong"));
          }
      }
      elseif($_POST['type']==5)
      {
          $csid1=array();
          $subid1=array();
          $type1=array();
          
          $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
          if(mysqli_num_rows($query)>0)
          {
              $row=mysqli_fetch_assoc($query);
              $subid=$row['subid'];
              $type=$row['type'];
              $csid=explode(',',$row['csid']);
              
              if(in_array($_POST['cid'], $csid))
              {
                   $pos=0; $i=0;
                   $subid=explode(' ',$row['subid']);
                   $type=explode(' ',$row['type']);
                   
                    foreach($csid as $couurseid)
                    {
                        if($couurseid==$_POST['cid'])
                        {
                            $pos=$i;
                        }
                        $i++;
                    }
                    
                    $subid[$pos]=$subid[$pos].','.$_POST['sid'];
                    $type[$pos]=$type[$pos].'*1,2,3';
                    
                    $csid=$row['csid'];  
                    $subid=implode(' ',$subid);
                    $type=implode(' ',$type);
                    
              }
              else
              {
                   $csid=$row['csid'].','.$_POST['cid'];
                   $subid=$row['subid'].' '.$_POST['sid'];
                   $type=$row['type'].' 1,2,3';
              }
              
              
              $payment=mysqli_query($con,"INSERT INTO `payment`( `p_id`, `amount`, `subject_id`, `course_id`, `type`, `user_id`, `data`) VALUES ('".$_POST['p_id']."','".$_POST['amount']."','".$_POST['sid']."','".$_POST['cid']."','".$_POST['type']."','".$_POST['user_id']."','".$_POST['data']."')");
              if($payment)
              {
              $final=mysqli_query($con,"update user set paid='1',subid='$subid',type='$type',csid='".$csid."' where user_id='".$_POST['user_id']."'");
              echo json_encode(array("status"=>"1","Response"=>"Data Inserted"));
              }
              else
              {
                  echo json_encode(array("status"=>"0","Response"=>"Payment Not Inserted"));
              }
          }
          else
          {
              echo json_encode(array("status"=>"0","Response"=>"User Id Wrong"));
          }
      
      }
      else
      {
          echo json_encode(array("status"=>"0","Response"=>"Invalide Type"));
      }
  }
?>