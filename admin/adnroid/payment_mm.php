<?php
 include("db.php");
    $response = array();
     $sub=array();
		mysql_set_charset("utf8");
		$type=$_REQUEST['type'];
		
		
	
	
	 if($_REQUEST['user_id']!='' && $_REQUEST['type']!='')
        {
         if($type=='1'){
/*  type 1- purchase all course-(like Bca)..include all subjects(including pdf,mcq,video)*/
            $query=mysqli_query($con,"select cource_id from cource");
              
               while( $row=mysqli_fetch_array($query)){
                   $data1[]=$row['cource_id'];
                   $course_id_is=$row['cource_id'];
                   /*Courses Subject*/
                    $query_sub=mysqli_query($con,"select id from subject where course_id='$course_id_is'");
             
                       while( $row_sub=mysqli_fetch_array($query_sub)){
                           $data2[]=$row_sub['id'];
                           $type=[1,2,3];
                          $seperated_types=implode(',',$type);
                           $delux_type[]=$seperated_types;
                       }
                    $temp_array_storage[]=implode(',',$data2);
                    $type_accum[]=implode('*',$delux_type);
                    unset($data2);
                     unset($delux_type);
                  
                   
                   
               }
            //   echo json_encode($type_accum);
            $courses=  implode(',',$data1);
            $subjects=  implode(' ',$temp_array_storage);
            $types_found=implode(' ',$type_accum);
            $query_data=mysqli_query($con,"UPDATE `user` SET `csid`='".$courses."',`subid`='".$subjects."',`type`='".$types_found."' where `user_id`='".$_REQUEST['user_id']."'");
         //echo "UPDATE `user` SET `csid`='".$courses."',`subid`='".$subjects."',`type`='".$_REQUEST['type']."' where `user_id`='".$_REQUEST['user_id']."'";
            }elseif($type=='2'){
/*type 2- puchase all mcq (BCA) .including all subjects*/    
	$pur_course_id=$_REQUEST['course_id'];
              /*Courses Subject*/
                    $query_sub=mysqli_query($con,"select id from subject where course_id='$pur_course_id'");
             
                       while( $row_sub=mysqli_fetch_array($query_sub)){
                           $data2[]=$row_sub['id'];
                           $type=[3];
                          $seperated_types=implode(',',$type);
                           $delux_type[]=$seperated_types;
                       }
                    $temp_array_storage[]=implode(',',$data2);
                    $type_accum[]=implode('*',$delux_type);
                    unset($data2);
                     unset($delux_type);

 
            $subjects=  implode(' ',$temp_array_storage);
            $types_found=implode(' ',$type_accum);
            $query_data=mysqli_query($con,"UPDATE `user` SET `csid`='".$pur_course_id."',`subid`='".$subjects."',`type`='".$types_found."' where `user_id`='".$_REQUEST['user_id']."'");
                
            }elseif($type=='3'){
/*type 3- first i purchase all mcq (BCA) and now i purchase all pdf,video same course(BCA)*/ 
	$pur_course_id=$_REQUEST['course_id'];
		$pur_types=explode(',',$_REQUEST['select_type']);
              /*Courses Subject*/
                    $query_sub=mysqli_query($con,"select id from subject where course_id='$pur_course_id'");
             
                       while( $row_sub=mysqli_fetch_array($query_sub)){
                           $data2[]=$row_sub['id'];
                           $type=$pur_types;
                          $seperated_types=implode(',',$type);
                           $delux_type[]=$seperated_types;
                       }
                    $temp_array_storage[]=implode(',',$data2);
                    $type_accum[]=implode('*',$delux_type);
                    unset($data2);
                     unset($delux_type);

 
            $subjects=  implode(' ',$temp_array_storage);
            $types_found=implode(' ',$type_accum);
            $query_data=mysqli_query($con,"UPDATE `user` SET `csid`='".$pur_course_id."',`subid`='".$subjects."',`type`='".$types_found."' where `user_id`='".$_REQUEST['user_id']."'");
              }elseif($type=='4'){
/*type 4- first i purchase all mca (BCA) and now i purchase all pdf,mcq,video(Other Course BA)*/ 
$pur_course_id=explode(',',$_REQUEST['course_id']);

	$pur_types=explode(',',$_REQUEST['select_type']);
   foreach($pur_course_id as $pur_course_pid){
                   $data1[]=$pur_course_pid;
                   $course_id_is=$pur_course_pid;
                   /*Courses Subject*/
                    $query_sub=mysqli_query($con,"select id from subject where course_id='$course_id_is'");
             
                       while( $row_sub=mysqli_fetch_array($query_sub)){
                           $data2[]=$row_sub['id'];
                           $type=$pur_types;
                          $seperated_types=implode(',',$type);
                           $delux_type[]=$seperated_types;
                       }
                    $temp_array_storage[]=implode(',',$data2);
                    $type_accum[]=implode('*',$delux_type);
                    unset($data2);
                     unset($delux_type);
                  
                   
                   
               }
               //print_r($data1);
            //   echo json_encode($type_accum);
            $courses=  implode(',',$data1);
            $subjects=  implode(' ',$temp_array_storage);
            $types_found=implode(' ',$type_accum);
            $query_data=mysqli_query($con,"UPDATE `user` SET `csid`='".$courses."',`subid`='".$subjects."',`type`='".$types_found."' where `user_id`='".$_REQUEST['user_id']."'");


            }elseif($type=='5'){
/*type 5 - now puchase subject wise in any course*/  
	$pur_course_id=$_REQUEST['course_id'];
	$pur_subject_id=explode(',',$_REQUEST['subject_id']);
	$pur_types=explode(',',$_REQUEST['select_type']);
              /*Courses Subject*/
                   foreach($pur_subject_id as $pur_subject_pid){
                           $data2[]=$pur_subject_pid['id'];
                           $type=$pur_types;
                          $seperated_types=implode(',',$type);
                           $delux_type[]=$seperated_types;
                       }
                    $temp_array_storage[]=implode(',',$data2);
                    $type_accum[]=implode('*',$delux_type);
                    unset($data2);
                     unset($delux_type);

 
            $subjects=  implode(' ',$temp_array_storage);
            $types_found=implode(' ',$type_accum);
            $query_data=mysqli_query($con,"UPDATE `user` SET `csid`='".$pur_course_id."',`subid`='".$subjects."',`type`='".$types_found."' where `user_id`='".$_REQUEST['user_id']."'");
                




            }else{
                $response["success"] = 0;
    			$response["message"] = "Invalid Type Selected";
            }
/*imp.. validate course only 6 months from purchase date after that cousre or subject expire..*/		
		
            if($query_data)
            {
                $response["success"] = 1;
			$response["message"] = "Updated Successfully";
            }
            else
            {
                $response["success"] = 0;
			$response["message"] = "Not Updated";
            }
            echo json_encode($response);
        }
	else
	{
        $response["success"] = 0;
        $response["message"] = "Please Enter correct details";
        echo json_encode($response);
    }
?>