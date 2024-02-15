<?php
include("db.php");
       if($_POST['token']=='vivek' && $_POST['user_id']!=''){
       $jsonObj = array();
		$cat_order = API_CAT_ORDER_BY;
 	    
 	    $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
 	    if(mysqli_num_rows($query)>0)
 	    {
 	        $row=mysqli_fetch_assoc($query);
 	        if($row['paid']=='1')
 	        {
 	          $type=explode(' ',$row['type']);
              $subid=explode(' ',$row['subid']);
              $csid=explode(',',$row['csid']);
              
              $i=0;
              foreach($csid as $course)
              {
                  $subid1=explode(',',$subid[$i]);
                  $type1=explode('*',$type[$i]);
                  $j=0;
                  foreach($subid1 as $val)
                  {
                    $type2=explode(',',$type1[$j]);
                      foreach($type2 as $out)
                      {
                          if($out==1)
                          {
                            $url = 'http://www.appcreator.co.in/infotrade/video/images/';
		$query1="SELECT id,'VIDEO' as datatype,video_title as name,video_url as link,'http://www.appcreator.co.in/infotrade/video/pdf/videoicon.png' as thambnail,featured_video as featured_type,video_type as type FROM tbl_video where featured_video='1' and subject_id='$val'";
		$sql1 = mysqli_query($con,$query1)or die(mysql_error());
		if(mysqli_num_rows($sql1)>0){
		while($data = mysqli_fetch_assoc($sql1))
		{
		    $data['featured_video']='0';
			array_push($jsonObj,$data);
		}

		}  
                          }
                          if($out==2)
                          {
                           $url = 'http://ksbmresearch.com/video/images/';
		                   $query="SELECT id,'PDF' as datatype,pdf_name as name,CONCAT('http://ksbmresearch.com/video/pdf/',pdf) as link,'http://ksbmresearch.com/video/pdf/pdficon.png' as thambnail,featured_pdf as featured_type,'Null' as type FROM tbl_pdf where featured_pdf='1' and subject_id='$val'";
		                   $sql = mysqli_query($con,$query)or die(mysql_error());
		                   if(mysqli_num_rows($sql)>0){
	            	       while($data = mysqli_fetch_assoc($sql))
		                    {
		                   $data['featured_pdf']='0'; 
			               array_push($jsonObj,$data);
		                    }
		                   }
                          
                          }
                          if($out==3)
                          {
                              $query=mysqli_query($con,"select 'MCQ' as datatype,exam_time as link,name,id,'http://ksbmresearch.com/video/pdf/mcqimg.png' as thambnail,'0' as featured_type,'Null' as type from exam where featured_mcq='1' and subjectid='$val'");
    if(mysqli_num_rows($query)>0)
    {
        while($row=mysqli_fetch_assoc($query))
        {
            $row['featured_mcq']='0';
            $row['link']=$row['link']*60000;
            array_push($jsonObj,$row);
        }
    }
                          }
                      }
                      
                    $j++;
                  
                  }
                  
                  $i++;
              }    
 	        }
 	        
 	    }
 	    
 	    
 	    
		$url = 'http://ksbmresearch.com/video/images/';
		$query="SELECT id,'PDF' as datatype,pdf_name as name,CONCAT('http://ksbmresearch.com/video/pdf/',pdf) as link,'http://ksbmresearch.com/video/pdf/pdficon.png' as thambnail,featured_pdf as featured_type,'Null' as type FROM tbl_pdf where featured_pdf='0' ";
		$sql = mysqli_query($con,$query)or die(mysql_error());
		if(mysqli_num_rows($sql)>0){
		while($data = mysqli_fetch_assoc($sql))
		 {
			array_push($jsonObj,$data);
		 }
		}
		
	    
	    $url = 'http://ksbmresearch.com/video/images/';
		$query1="SELECT id,'VIDEO' as datatype,video_title as name,video_url as link,'http://ksbmresearch.com/video/pdf/videoicon.png' as thambnail,featured_video as featured_type,video_type as type FROM tbl_video where featured_video='0'
		         ";
		$sql1 = mysqli_query($con,$query1)or die(mysql_error());
		if(mysqli_num_rows($sql1)>0){
		while($data = mysqli_fetch_assoc($sql1))
		{
			array_push($jsonObj,$data);
		}

		}
		
		$query2="SELECT cid as id,'COURSE' as datatype,'Null' as link,category_name as name,'Null' as link,'http://ksbmresearch.com/video/pdf/courseimg.png' as thambnail,'0' as featured_type,'Null' as type FROM tbl_category";
		$sql2 = mysqli_query($con,$query2)or die(mysql_error());
		if(mysqli_num_rows($sql2)>0){
		while($data = mysqli_fetch_assoc($sql2))
		{
			array_push($jsonObj,$data);
		}

		}
		$query3="SELECT id,'SUBJECT' as datatype,'Null' as link,subject_name as name,'http://ksbmresearch.com/video/pdf/subjectimg.png' as thambnail,'0' as featured_type,'Null' as type  FROM subject";
		$sql3 = mysqli_query($con,$query3)or die(mysql_error());
		if(mysqli_num_rows($sql3)>0){
		while($data = mysqli_fetch_assoc($sql3))
		{
			array_push($jsonObj,$data);
		}

		}
		$query=mysqli_query($con,"select 'MCQ' as datatype,exam_time as link,name,id,'http://ksbmresearch.com/video/pdf/mcqimg.png' as thambnail,'0' as featured_type,'Null' as type from exam where featured_mcq='0'
");
    if(mysqli_num_rows($query)>0)
    {
        while($row=mysqli_fetch_assoc($query))
        {
            $row['link']=$row['link']*60000;
            array_push($jsonObj,$row);
        }
    }
		
		
		$set=$jsonObj;
		echo json_encode($set);   
       }
       else
       {
           echo json_encode(array("status"=>"0","Response"=>"No Data Found"));
       }
 	
?>