<?php

///////
function push_notification($DeviceToken,$title,$body,$image){
  //$time_tag=" ".date('Y-m-d h:i A'); 
  $data = array(
          'body' => $body,
          'title' => $title,
          'image'=>$image,
          'vibrate' => 1,
          'sound' => "default",
          'badge' => '1',
      );

print_r($data);

  // $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
  // $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');

  //$FCMFields = array('to' => $DeviceToken, 'priority'=> "high", 'notification' 'data' => $data  , 'android' => $icon);

  $FCMFields = array('to' => $DeviceToken, 'priority'=> "high", 'notification' => $data);
  //FCM API end-point
  $url = 'https://fcm.googleapis.com/fcm/send';
  //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
  $server_key = 'AAAAq6-fH04:APA91bG7FKq3HJNrjspQbMQhC0NPJaMAypHYzfKRRswUXvB0Cqz4429NI3czWj2BU3G50BkEN5LNklZX9hNRtxs91bO2Kc4gLQtPMGXs-_u1lSjWL1PH2gcqc6SALU5tzxVzcePSd1Cw';
  //header with content_type api key
  $headers = array(
      'Content-Type:application/json',
      'Authorization:key='.$server_key
  );
  //CURL request to route notification to FCM connection server (provided by Google)
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($FCMFields) );
  $result = curl_exec($ch);
  if ($result === FALSE) {
      die('Oops! FCM Send Error: ' . curl_error($ch));
  }
  curl_close($ch);
  return true;
}
    

//////
        $title="";$body="";$image="change_password.png";
		$title=" image test NOTIFY "; 
		$body="IMAGE NOTIFICATION TEST ANKIT"; 
		$base_url='http://angirasuratgarhlive.com/ksbmadmin';
		if($image!=""){
		$image=$base_url.'/images/notification/'.$image; 
		}

 		        $p='AAAAq6-fH04:APA91bG7FKq3HJNrjspQbMQhC0NPJaMAypHYzfKRRswUXvB0Cqz4429NI3czWj2BU3G50BkEN5LNklZX9hNRtxs91bO2Kc4gLQtPMGXs-_u1lSjWL1PH2gcqc6SALU5tzxVzcePSd1Cw';		       
		        
		       echo push_notification($p,$title,$body,$image);