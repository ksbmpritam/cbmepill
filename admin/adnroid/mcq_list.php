<?php
include("db.php");
if($_POST['subject_wise_videos']!='' && $_POST['user_id']!='' && $_POST['course_id']!='')
 	{
 	   
 	  $query=mysqli_query($con,"select * from user where user_id='".$_POST['user_id']."'");
 	  while($row=mysqli_fetch_assoc($query))
 	  {
 	      
 	       
 	      if($row['paid']=='1')
 	      {
 	        $type=explode(' ',$row['type']);
            $csid=explode(' ',$row['subid']);
            $i=0;
            foreach($csid as $val)
            {
                $csid1=explode(',',$csid[$i]);
                $type1=explode(',',$type[$i]);
                 foreach($csid1 as $val1)
                 {
                   if($val1==$_POST['subject_wise_videos'])
                   {
                      
                       foreach($type1 as $val2)
                       {
                         if($val2=='3')
                         {
                          $jsonObj= array();
		                  // $cat_order=API_CAT_ORDER_BY;
		                   $url = 'http://angirasuratgarhlive.com/ksbmadmin/images/';
		                   $pd_url = 'http://angirasuratgarhlive.com/ksbmadmin/uploads/';
	                        $query="SELECT tbl_mcq.* ,concat('$pd_url',pdf) as id FROM tbl_mcq where  cat_id='".$_POST['course_id']."' AND subject_id = '".$_POST['subject_wise_videos']."' order by rangee ASC";
		                   $sql = mysqli_query($con,$query)or die(mysql_error());
		                   while($data = mysqli_fetch_assoc($sql))
		                   {
		                    $data['featured_pdf']='0';
			                array_push($jsonObj,$data);
	 	                   }
	                    	$set['VIDEO_CAT'] = "";
	                    
		      }
                       }
                      
                   }
                 }
                $i++;
            }
            if(empty($set))
            {
              echo"frerfer";
 	          $jsonObj= array();
// 		$cat_order=API_CAT_ORDER_BY;
		$url = 'http://angirasuratgarhlive.com/ksbmadmin/images/';
	echo	$query="SELECT tbl_mcq.*  FROM tbl_mcq where  cat_id='".$_POST['course_id']."' AND  subject_id = '".$_POST['subject_wise_videos']."' 
		          order by rangee ASC";
		$sql = mysqli_query($con,$query)or die(mysql_error());
		while($data = mysqli_fetch_assoc($sql))
		{
			array_push($jsonObj,$data);
		}

		$set['VIDEO_CAT'] = $jsonObj;
 	        
            }
 	      header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
 	       }
 	      else
 	      {
 	          echo"frgvards";
 	    $jsonObj = array();
// 		$cat_order = API_CAT_ORDER_BY;
		$url = 'http://angirasuratgarhlive.com/ksbmadmin/images/';
		$query="SELECT tbl_mcq.* FROM tbl_mcq where  cat_id='".$_POST['course_id']."' AND subject_id = '".$_POST['subject_wise_videos']."' 
		          order by rangee ASC";
		$sql = mysqli_query($con,$query)or die(mysql_error());
		while($data = mysqli_fetch_assoc($sql))
		{
			array_push($jsonObj,$data);
		}

		$set['VIDEO_CAT'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();
 	      }
 	  }
 	}
 	else
 	{
 	    echo json_encode(array("status"=>"0","response"=>"Fill ALL Data"));
 	}
?>