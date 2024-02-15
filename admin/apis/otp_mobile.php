<?php
date_default_timezone_set('Asia/Kolkata');
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, UPDATE");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $api_data = json_decode(file_get_contents("php://input"));

       $mobile = $_POST['mobile'];
    // Check if the 'mobile' property exists in the JSON request
    if (isset($mobile)) {
        // echo $mobile;die;
        // Generate a random OTP
        $otp = rand(100000, 999999);

        $api_key = '46521027EB1120';
        $contacts = $mobile;
        $from = 'SPTSMS';
        $sms_text = 'Your OTP is ' . $otp . ' SELECTIAL'; // Do not urlencode

        // Prepare data as form-data
        $data = array(
            'key' => $api_key,
            'campaign' => 0,
            'routeid' => 9,
            'type' => 'text',
            'contacts' => $contacts,
            'senderid' => $from,
            'msg' => $sms_text,
            'template_id' => '1707166619134631839'
        );

        //Submit to server

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://msg.pwasms.com/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Convert data to form-data
        $response = curl_exec($ch);
        curl_close($ch);

        // Create a response JSON object
        $response_data = array(
            'message' => 'OTP sent successfully',
            'otp' => $otp
        );

        echo json_encode($response_data);
    } else {
        // Handle missing 'mobile' property in the JSON request
        echo json_encode(array('message' => 'Mobile number not provided'));
    }
} else {
    echo json_encode(array('message' => 'Method False'));
}
?>
