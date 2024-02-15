<?php
 include("db.php");
    $respons = array();


        $result = mysqli_query($con,"select * from  tbl_category");
        
              $output=array();
	$i=0;
	while($row = mysqli_fetch_assoc($result))
	{
		 $output[$i]=array();
		 $output[$i]['cid']    =$row['cid'];
		 $output[$i]['title']       ="";//$row['title'];
	     $output[$i]['description'] = preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags($row['description']));
	     
	     $output[$i]['price_1']     = "";//$row['price_1'];
	     $output[$i]['price_2']     = "";//$row['price_2'];
	     $output[$i]['price_3']     = "";//$row['price_3'];
	     
	     $output[$i]['location']    = "";//$row['location'];
	     $output[$i]['latitude']    = "";//$row['latitude'];
	     $output[$i]['longtitude']  = "";//$row['longtitude'];
	     $output[$i]['category_name']= $row['category_name'];
	     //$output[$i]['image']        = "https://parikshagyan.com/images/".urlencode ($row['category_image']);
	     $output[$i]['image']        = "http://angirasuratgarhlive.com/ksbmadmin/images/".$row['category_image'];
	     $event_id                   = $row['event_id'];
	     
	     $result2 = mysqli_query($con,"select * from event_gallary where event_id ='$event_id'");
	        $a = 0 ;
	     	while($row2 = mysqli_fetch_assoc($result2))
         	{
         	  $output2[$a]=array();
         	  $output2[$a]['event_gallary_id']    =$row2['event_gallary_id'];
         	  $output2[$a]['img']    ="http://angirasuratgarhlive.com/ksbmadmin/images/".$row2['img'];
         	  
         	  
         	  $output[$i]['event_gallary']= $output2; 
         	  $a++;
         	}
        	
     	$i++;
	}
             

echo json_encode(array("result"=>$output));

?>
