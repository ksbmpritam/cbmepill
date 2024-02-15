<?php
     include("db.php");
      if (!empty($_POST)) {
          
    if($_POST['userid']=='')
    {
        echo json_encode(array("status"=>"0","Response"=>"Blank User Id"));
    }
    elseif($_POST['subject_id']=='')
    {
        echo json_encode(array("status"=>"0","Response"=>"Blank Subject Id"));
    }
    elseif($_POST['coupon_id']==''){
        
                echo json_encode(array("status"=>"0","Response"=>"Blank Coupons Code"));
    }
    else
    {
        
        
        
        $sql_coupons=mysqli_query($con,"SELECT * FROM `coupons_master` WHERE id='".$_POST['coupon_id']."'");
        $coupon_data=mysqli_fetch_assoc($sql_coupons);
         
        
            
           if(mysqli_num_rows($sql_coupons)>0){ 
        
        $userid=$_POST['userid'];
        
        $second = mysqli_fetch_assoc(mysqli_query($con,"select course_id from subject where id='".$_POST['subject_id']."'"))['course_id'];
        
        $sql = mysqli_query($con,"select * from user where user_id='$userid'");
        if(mysqli_num_rows($sql)>0)
        {
         $row=mysqli_fetch_assoc($sql);
         
         # IF COURSE FOUND AS BLANNK IN USER TABLE
         if($row['csid']=='')
         {
          $allamount='0';
          $allmcqamount='0';   
            // ECHO "select * from subject where course_id='".$second."'";DIE;
          $query=mysqli_query($con,"select * from subject where course_id='".$second."'");
         if(mysqli_num_rows($query)>0)
         {
             $data=array(); $video=0;$pdf=0;$mcq=0;
             while($row=mysqli_fetch_assoc($query))
             {
                 $amount=explode(',',$row['amount']);
                 $amr=0;
                 foreach($amount as $am)
                 {
                    $allamount+=$am;
                    if($amr==0)
                    {
                        if($coupon_data['coupons_flat_type']=='Flat Percentage'){
                            
                            
                        $video+=$am;
                        $discount=$video*$coupon_data['coupons_flat_value']/100;
                        $data['video']=$video-$discount;
                        }elseif($coupon_data['coupons_flat_type']=='Flat Amount'){
                            
                            $video+=$am;
                        $discount=$coupon_data['coupons_flat_value'];
                        $data['video']=$video-$discount;
                        }
                    }
                    if($amr==1)
                    {
                        
                        if($coupon_data['coupons_flat_type']=='Flat Percentage'){
                        $pdf+=$am;
                        $discount=$pdf*$coupon_data['coupons_flat_value']/100;
                        $data['pdf']=$pdf-$discount;
                            
                            
                        }elseif($coupon_data['coupons_flat_type']=='Flat Amount'){
                            
                             $pdf+=$am;
                        $discount=$coupon_data['coupons_flat_value'];
                        $data['pdf']=$pdf-$discount;
                            
                            
                            
                        }
                        
                    }
                    if($amr==2)
                    {
                        
                        if($coupon_data['coupons_flat_type']=='Flat Percentage'){
                            
                        $mcq+=$am;
                        $discount=$mcq*$coupon_data['coupons_flat_value']/100;
                        $data['mcq']=$mcq-$discount;
                        
                        }elseif($coupon_data['coupons_flat_type']=='Flat Amount'){
                            
                             $mcq+=$am;
                        $discount=$coupon_data['coupons_flat_value'];
                        $data['mcq']=$mcq-$discount;
                            
                        }
                    }
                    $amr++;
                 }
                 
                 $i=0;
                 foreach($amount as $am)
                 {
                    if($i==2)
                    {
                     $allmcqamount+=$am; 
                    }
                    $i++;
                     
                 }
             }
         }
             
              echo json_encode(array("status"=>"1","Response"=>"1","amount"=>$data,"mcqamount"=>$allmcqamount,"coupon_data"=>$coupon_data)); die;
         }
         
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
        
        
        
    }else{
        
         echo json_encode(array("status"=>"0","response"=>"Coupon Code Not Exist"));
        
    }
    }
    
}
else
{
    echo json_encode(array("status"=>"0","response"=>"Something Wrong"));
}
        ?>
		