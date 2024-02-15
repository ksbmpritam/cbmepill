<?php
$api_key = '45E8C845640108';
$contacts = '9319062583';
$from = 'VIPHYO';
$sms_text = urlencode('Hello People, have a great day');

//Submit to server

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, "http://msg.pwasms.com/app/smsapi/index.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=0&routeid=14&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
$response = curl_exec($ch);
curl_close($ch);
echo $response;

?>