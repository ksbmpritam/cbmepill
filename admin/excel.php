<?php

include("includes/connection.php");
  
	    $data=array();
	    $query=mysqli_query($mysqli,"select name,mobile,email,last_name,educ_qual,stream,country,state from user order by user_id");
	    if(mysqli_num_rows($query)>0)
	    {
	        while($row=mysqli_fetch_assoc($query))
	        {
	            $data[]=$row;
	        }
	    }
	     
	   $csvData[] =array("Name","Mobile","Email","EDUCATION QUALIFICATION","STREAM","COUNTRY","STATE");
	   if($query){	
		foreach($data as $cnt){
		
			$csvData[]=array($cnt['name'].' '.$cnt['last_name'],$cnt['mobile'],$cnt['email'],$cnt['educ_qual'],$cnt['stream'],$cnt['country'],$cnt['state']);
		}
	   }
	   ob_clean();
		header("Pragma: public");			
	header("Expires: 0");			
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	header("Content-Type: application/force-download");			
	header("Content-Type: application/octet-stream");	
	header("Content-Type: application/download");			
	header("Content-Disposition: attachment;filename=All_user".time().".csv");		
	header("Content-Transfer-Encoding: binary");		
	$df = fopen("php://output", 'w');			
	array_walk($csvData, function($row) use ($df) {	
	fputcsv($df, $row);		
	});
	


?>
