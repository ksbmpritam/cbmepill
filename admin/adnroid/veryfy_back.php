<?php
     include("db.php");
     
if(isset($_REQUEST['subject_id']) && isset($_REQUEST['user_id']) )
{
    if($_POST['user_id']=='')
    {
        echo json_encode(array("status"=>"0","Response"=>"Blank User Id"));
    }
    elseif($_POST['subject_id']=='')
    {
        echo json_encode(array("status"=>"0","Response"=>"Blank Subject Id"));
    }
    
    else
    {
        
        // $sql_coupons=mysqli_query($con,"SELECT * FROM `coupons_master` WHERE ");
        // $coupon_data=mysqli_fetch_assoc($sql_coupons);
        
        $user_id=$_POST['user_id'];
        $subject_id=$_POST['subject_id'];
        
        // to findout the course_id from the subject table
        $second = mysqli_fetch_assoc(mysqli_query($con,"select course_id from subject where id='$subject_id'"))['course_id'];
        
        // if user access
        $sql = mysqli_query($con,"select * from user where user_id='$user_id'");
        if(mysqli_num_rows($sql)>0)
        {
         $row=mysqli_fetch_assoc($sql);
         
         # IF COURSE FOUND AS BLANNK IN USER TABLE
         if($row['csid']=='')
         {
              $allamount='0';
              $allmcqamount='0';   
           
              $query=mysqli_query($con,"select * from subject where course_id='".$second."' AND id='$subject_id'");
             if(mysqli_num_rows($query)>0)
             {
                 $data=array(); $video=0;$pdf=0;$mcq=0;
                 while($row=mysqli_fetch_assoc($query))
                 {
                     $amount=explode(',',$row['amount']);
                     
                    //  print_r($amount);
                    //  exit;
                     
                     $data['video']=$amount[0];
                     $data['pdf']=$amount[1];
                     $data['mcq']=$amount[2];
                     
                    
                    //  $amr=0;
                    //  foreach($amount as $am)
                    //  {
                    //     $allamount+=$am;
                    //     if($amr==0)
                    //     {
                    //         $video+=$am;
                    //         $data['video']=$video;
                            
                    //     }
                    //     if($amr==1)
                    //     {
                    //         $pdf+=$am;
                    //         $data['pdf']=$pdf;
                    //     }
                    //     if($amr==2)
                    //     {
                    //         $mcq+=$am;
                    //         $data['mcq']=$mcq;
                    //     }
                    //     $amr++;
                    //  }
                     
                    //  $i=0;
                    //  foreach($amount as $am)
                    //  {
                    //     if($i==2)
                    //     {
                    //      $allmcqamount+=$am; 
                    //     }
                    //     $i++;
                         
                    //  }
                 }
             }
             
              echo json_encode(array("status"=>"1","Response"=>"1","amount"=>$data)); die;
         }
         
         # IF COURSE FOUND IN USER TABLE
         $csid=explode(',',$row['csid']);
         
         $i=0; $course_pos=0;
         foreach($csid as $course)
         {
             if($course == $second)
             { 
                $course_pos = $i; 
             }
             $i++;
         }
         
          $subid = explode(' ',$row['subid']);
          $type  = explode(' ',$row['type']);
          //echo "<pre>";print_r($type[0]);die;

         if($course_pos=='0')
         {
            
             $veri='0'; 
             for($lo=0;$lo<count($subid);$lo++)
             {
                 $type1=explode('*',$type[$lo]);
                 if($type1[0]=='1,2,3')
                 {
                    $veri=1; 
                 } 
                 elseif($type1[0]=='3')
                 {
                    $veri=2;  
                 }
                 
             }
             if($veri==1)
             {
                 
              $list=array();
             $query=mysqli_query($con,"select * from subject where course_id='".$second."'");
             if(mysqli_num_rows($query)>0)
             { 
              $listo=0;
              while($row=mysqli_fetch_assoc($query))
              {
                 $allamount=0;
                 $amount=explode(',',$row['amount']);
                 foreach($amount as $am)
                 {
                    $allamount+=$am; 
                 }
                 $list[$listo]['id']=$row['id'];
                 $list[$listo]['name']=$row['subject_name'];
                 $list[$listo]['amount']=$allamount;
                 $listo++;
              }
             }
              $fullamount=0;
              foreach($list as $fam)
              {
                  $fullamount+=$fam['amount'];
              }
              echo json_encode(array("status"=>"1","Response"=>"4","amount"=>$fullamount,"list"=>$list,"coupon_data"=>$coupon_data));   
             }
             elseif($veri==2)
             {
                 
                 $csid=explode(',',$row['csid']);
                 
                 if(in_array($second,$csid))
                 {
                     $list=array();
             $query=mysqli_query($con,"select * from subject where course_id='".$second."'");
             if(mysqli_num_rows($query)>0)
             { 
              $listo=0;$allamount=0; $data=array(); $video=0;$pdf=0;$mcq=0;
              while($row=mysqli_fetch_assoc($query))
              {
                 
                 $amount=explode(',',$row['amount']);
                 $i=0;
                 foreach($amount as $am)
                 {
                    
                        if($i==0)
                        {
                            $video+=$am;
                            $data['video']=$video;
                        }
                        if($i==1)
                        {
                            $pdf+=$am;
                            $data['pdf']=$pdf;
                        }
                        
                    if($i !=2) 
                    {
                     $allamount+=$am;
                    }
                    $i++;
                 }
                 
              }
             }
              
              echo json_encode(array("status"=>"1","Response"=>"3","amount"=>$allamount,"list"=>$data,"coupon_data"=>$coupon_data));
                 }
                 else
                 {
                     
                     $list=array();
             $query=mysqli_query($con,"select * from subject where course_id='".$second."'");
             if(mysqli_num_rows($query)>0)
             { 
              $listo=0;$allamount=0; $data=array(); $video=0;$pdf=0;$mcq=0;
              while($row=mysqli_fetch_assoc($query))
              {
                 
                 $amount=explode(',',$row['amount']);
                 $amr=0;
                 foreach($amount as $am)
                 {
                    $allamount+=$am;
                    if($amr==0)
                    {
                        $video+=$am;
                        $data['video']=$video;
                    }
                    if($amr==1)
                    {
                        $pdf+=$am;
                        $data['pdf']=$pdf;
                    }
                    if($amr==2)
                    {
                        $mcq+=$am;
                        $data['mcq']=$mcq;
                    }
                    $amr++;
                 }
                 
              }
             }
              
              echo json_encode(array("status"=>"1","Response"=>"2","amount"=>$data));
                 
                 }
                #  START TO GET PAYMENT OF VIDEO AND PDF
                 
              
                //echo json_encode(array("status"=>"1","Response"=>"2")); 
             
            #  END TO GET PAYMENT OF VIDEO AND PDF     
             }
             else
             {
                $list=array();
             $query=mysqli_query($con,"select * from subject where course_id='".$second."'");
             if(mysqli_num_rows($query)>0)
             { 
              $listo=0;$allamount=0; $data=array(); $video=0;$pdf=0;$mcq=0;
              while($row=mysqli_fetch_assoc($query))
              {
                 
                 $amount=explode(',',$row['amount']);
                $amr=0;
                 foreach($amount as $am)
                 {
                    $allamount+=$am;
                    if($amr==0)
                    {
                        $video+=$am;
                        $data['video']=$video;
                    }
                    if($amr==1)
                    {
                        $pdf+=$am;
                        $data['pdf']=$pdf;
                    }
                    if($amr==2)
                    {
                        $mcq+=$am;
                        $data['mcq']=$mcq;
                    }
                    $amr++;
                 }
                 
              }
             }
              
              echo json_encode(array("status"=>"1","Response"=>"2","amount"=>$data));   
             }
         }
         else
         {
             # IF POST COURSE EXIST BUT AT OTHER INDEX OF CID OF USER 
           if (in_array($second, $csid))
             {
                 
                $subid1=explode(',',$subid[$course_pos]);
                $type1=explode('*',$type[$course_pos]);
                
                
                $subid1 = join("','",$subid1);
                
                
                if($type1[0]=='3')
                {
                    $query=mysqli_query($con,"select * from subject where course_id='".$second."' and id NOT IN ($subid1)");
                    if(mysqli_num_rows($query)>0)
                   {
                       $data=array(); $video=0;$pdf=0;$mcq=0;
                     while($row=mysqli_fetch_assoc($query))
                     {
                       $amount=explode(',',$row['amount']);
                       $i=0;
                      foreach($amount as $am)
                      {
                        if($i==0)
                        {
                            $video+=$am;
                            $data['video']=$video;
                        }
                        if($i==1)
                        {
                            $pdf+=$am;
                            $data['pdf']=$pdf;
                        }
                        if($i!=2)
                        {
                         $allmcqamount+=$am; 
                        }
                    
                    $i++;
                     
                      }
             }
         }
                    
                    
                    echo json_encode(array("status"=>"1","Response"=>"3","amount"=>$allmcqamount,"list"=>$data,"coupon_data"=>$coupon_data));
                }
                
                if($type1[0]=='1,2,3')
                {
                    
                    
                 $list=array();
                 $query=mysqli_query($con,"select * from subject where course_id='".$second."'  and id NOT IN ($subid1)");
             if(mysqli_num_rows($query)>0)
             { 
              $listo=0;
              while($row=mysqli_fetch_assoc($query))
              {
                 $allamount=0;
                 $amount=explode(',',$row['amount']);
                 foreach($amount as $am)
                 {
                    $allamount+=$am; 
                 }
                 $list[$listo]['id']=$row['id'];
                 $list[$listo]['name']=$row['subject_name'];
                 $list[$listo]['amount']=$allamount;
                 $listo++;
              }
             }
              $fullamount=0;
              foreach($list as $fam)
              {
                  $fullamount+=$fam['amount'];
              }
              echo json_encode(array("status"=>"1","Response"=>"4","amount"=>$fullamount,"list"=>$list,"coupon_data"=>$coupon_data));   
             
                }
                
             }  
         }

        }
    }
    
}
else
{
    echo json_encode(array("status"=>"0","response"=>"Something Wrong"));
}
        ?>
		