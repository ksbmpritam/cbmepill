<?php
     include("db.php");
  
		
		if (!empty($_POST)) {
    if($_POST['mobile']!='')
    {
    $mobile=$_POST['mobile'];
 
       
    $sql = "SELECT name FROM user where mobile = '$mobile'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
   
    $sth = mysqli_query($con,"SELECT * from user where mobile ='$mobile'");
    $rows = array();
    while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
       }



            $otp=rand(100000,999999);    
          $message = "Thank%20You%20For%20Using%20Angira%20Live%20App%20Your%20Otp%20Is%20".$otp;
          
        //   $apiKey="ajwshkowNoI-L2UgRgFLTOPdTY3JB5xwxD3zA5KulD";
          
        //   $sender="infoTd";
          
          // Prepare data for POST request
// 	$data = 'apikey=' . $apiKey . '&numbers=' . $mobile . "&sender=" . $sender . "&message=" . $message;
 
	// Send the GET request with cURL
// 	$ch = curl_init('https://api.textlocal.in/send/?' . $data);
          
    // https://api.textlocal.in/send/?apikey=ajwshkowNoI-L2UgRgFLTOPdTY3JB5xwxD3zA5KulD&numbers='.$mobile.'&sender=infoTd&message='.$message.'      
          
         // $ch      = curl_init('https://api.textlocal.in/send/?apikey=ajwshkowNoI-oKfGNTS2I9fiAT6HX7ycHKR5wtkn7W&numbers='.$mobile.'&sender=infoTd&message='.$message.'');
         
        //   $ch      = curl_init('http://msg.pwasms.com/app/smsapi/index.php?key=45E8C845640108&campaign=0&routeid=9&type=text&contacts='.$mobile.'&senderid=VIPHYO&msg='.$message.'');
       $ch= curl_init('http://msg.pwasms.com/app/smsapi/index.php?key=56087BB805B361&campaign=0&routeid=69&type=text&contacts='.$mobile.'&senderid=WRLDTX&msg='.$message.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
       // print_r($data);die;
        curl_close($ch);
	      
    echo json_encode(array("status"=>"2","otp"=>$otp,"Response"=>$rows));
        
       
    }
    else
    {
        $otp=rand(100000,999999);    
          $message = "Thank%20You%20For%20Using%20Angira%20Live%20App%20Your%20Otp%20Is%20".$otp;
	       
	       //https://www.fast2sms.com/dev/bulk?authorization=AXis0OVFpaB7bm3dr5lLCQKGwZ4xvyqkcztoDjM2f9hYRES6gIDgYQtujATorSasGMh6e7LmKNbOi9ck&sender_id=InfoTd&message='.$message.'&language=english&route=p&numbers='.$mobile.''
	       
	       //$ch      = curl_init('https://www.fast2sms.com/dev/bulk?authorization=AXis0OVFpaB7bm3dr5lLCQKGwZ4xvyqkcztoDjM2f9hYRES6gIDgYQtujATorSasGMh6e7LmKNbOi9ck&sender_id=InfoTd&message='.$message.'&language=english&route=p&numbers='.$mobile.'');
	       
	       
// 	       $apiKey="ajwshkowNoI-L2UgRgFLTOPdTY3JB5xwxD3zA5KulD";
          
//           $sender="infoTd";
          
//           // Prepare data for POST request
// 	$data = 'apikey=' . $apiKey . '&numbers=' . $mobile . "&sender=" . $sender . "&message=" . $message;
 
// 	// Send the GET request with cURL
// 	$ch = curl_init('https://api.textlocal.in/send/?' . $data);
	       
	       
	       // $ch      = curl_init('https://api.textlocal.in/send/?apikey=ajwshkowNoI-oKfGNTS2I9fiAT6HX7ycHKR5wtkn7W&numbers='.$mobile.'&sender=infoTd&message='.$message.'');

	       // $ch      = curl_init('http://msg.pwasms.com/app/smsapi/index.php?key=45E8C845640108&campaign=0&routeid=9&type=text&contacts='.$mobile.'&senderid=VIPHYO&msg='.$message.'');
         $ch= curl_init('http://msg.pwasms.com/app/smsapi/index.php?key=56087BB805B361&campaign=0&routeid=69&type=text&contacts='.$mobile.'&senderid=WRLDTX&msg='.$message.'');
	       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
       // print_r($data);die;
        curl_close($ch);
    echo json_encode(array("status"=>"1","otp"=>$otp));
    
    
    }   
        
    }
}
else
{
    echo json_encode(array("status"=>"0","response"=>"Please Fill All Field"));
}

?>