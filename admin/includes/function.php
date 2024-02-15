<?php //error_reporting(0);

include("connection.php");

/**

 * Copyright 2017 Viaviweb.

 *

 * Licensed under the Apache License, Version 2.0 (the "License"); you may

 * not use this file except in compliance with the License. You may obtain

 * a copy of the License at

 *

 *     http://www.apache.org/licenses/LICENSE-2.0

 *

 * Unless required by applicable law or agreed to in writing, software

 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT

 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the

 * License for the specific language governing permissions and limitations

 * under the License.

 */


// This is for send notification throw firebase


function sendGCM($message, $id) {
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        "to" => $id,
        "collapse_key" => "type_a", 
        "notification" => array(
            "body" => $message['url'],
            "title" => $message['short_desc'],
            "image" => $message['image']."?format=jpg&crop=4560,2565,x790,y784,safe&fit=crop"
            ), 
        "data" => array(
            "body" => "Body of Your Notification in Data",
            "title" => "Title of Your Notification in Title",
            "key_1" => "Value for key_1",
            "key_2" => "Value for key_2"
            ),
    );
    
    $fields = json_encode ( $fields );

    $headers = array (
    'Authorization: key=' . "AAAA_8z_0H4:APA91bGPWjJ5C8Llt94KKIMmnG5htRcSG00odpj_ifjXzTrW7ra54WoVKutZIXCPrenC_YdTgZ7GcTI7m2MXAK8vbo4jMqBAzfpaJFelGOBwD-zN9N2kaygn-svi2KU-cmuavbTjLpBq",
    'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    curl_close ( $ch );
}










// This is to prevent sql injection

function filter($data){
    
    global $mysqli;
    
    return mysqli_real_escape_string($mysqli,$data);
       
}







function get_user_old_data($userid , $field){

    

    global $mysqli;



    $sql = "SELECT $field FROM user where user_id = '".$userid."'";       

    $result = mysqli_query($mysqli,$sql);

    $row = mysqli_fetch_array($result)[$field];

        return $row; 

    

}







function add_remove_array_converintostring($olds,$news){



$old=explode(',',$olds);

$new=explode(',',$news);



$result=array_diff($old,$new);

//print_r($result);

$newresult=array_merge($result,$new);

//print_r($newresult);

return implode(',',$newresult);

} 



function remove_array_converintostring($olds,$news){



$old=explode(',',$olds);

$new=explode(',',$news);



$result=array_diff($old,$new);

return implode(',',$result);

} 



#Admin Login

function adminUser($username, $password){

    

    global $mysqli;



    $sql = "SELECT id,username FROM tbl_admin where username = '".$username."' and password = '".$password."'";       

    $result = mysqli_query($mysqli,$sql);

    $num_rows = mysqli_num_rows($result);

     

    if ($num_rows > 0){

        while ($row = mysqli_fetch_array($result)){

            echo $_SESSION['ADMIN_ID'] = $row['id'];

                        echo $_SESSION['ADMIN_USERNAME'] = $row['username'];

                                      

        return true; 

        }

    }else{

        //echo "noo";

    }

    

}


function InsertLesson($table, $data){



    global $mysqli;

    $fields = array_keys( $data );  

    $values = array_map( array($mysqli, 'real_escape_string'), array_values( $data ) );

   //echo "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');";

   //exit;  

    // mysqli_query($mysqli, "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');") or die( mysqli_error($mysqli) );

    $query = "INSERT INTO $table (" . implode(",", $fields) . ") VALUES ('" . implode("','", $values) . "')";
    
    if (mysqli_query($mysqli, $query)) {
        return mysqli_insert_id($mysqli);
    } else {
        die("Error: " . $query . "<br>" . mysqli_error($mysqli));
    }


}


# Insert Data 

function Insert($table, $data){



    global $mysqli;

    //print_r($data);



    $fields = array_keys( $data );  

    $values = array_map( array($mysqli, 'real_escape_string'), array_values( $data ) );

    

   //echo "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');";

   //exit;  

    mysqli_query($mysqli, "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');") or die( mysqli_error($mysqli) );



}





function removeupdate_customer_course_subjectby_userid($userid,$newcourse_id_string,$newsubjects_ids){

    

    global $mysqli;

    // start the actual SQL statement

    

$sqli="SELECT * from user where user_id='$userid'";

$data=mysqli_query($mysqli,$sqli);

$user=mysqli_fetch_assoc($data);

$res="";

if($user){    

        $oldcourses=get_user_old_data($userid , 'csid');

       $courseids=remove_array_converintostring($oldcourses,$newcourse_id_string);

        

        $oldsubjects=get_user_old_data($userid , 'subid');    

        $subjectsids=remove_array_converintostring($oldsubjects,$newsubjects_ids);

$Type_sql="";

foreach($subjectsids as $val){

$Type.=implode('*','1,2,3');

}



$UPSQL="UPDATE `user` SET  `subid`='$subjectsids' , ".$Type_sql." `csid`='$courseids'  WHERE `user_id`='$userid' ";

  $data=mysqli_query($mysqli,$UPSQL);

      if(mysqli_affected_rows($mysqli)>0){

    	$res.="Record Update successfully";

    	}else{

    	$res.="Record Not Any update";

    	}

    

}else{

    $res="User not found in our record";

}    

return $res;

}



function update_customer_course_subjectby_userid1($userid,$newcourse_id_string,$newsubjects_ids){

    

    global $mysqli;

    // start the actual SQL statement

    

$sqli="SELECT * from user where user_id='$userid'";

$data=mysqli_query($mysqli,$sqli);

$user=mysqli_fetch_assoc($data);

$res="";

if($user){    

        $oldcourses=get_user_old_data($userid , 'csid');

       $courseids=add_remove_array_converintostring($oldcourses,$newcourse_id_string);

        

        $oldsubjects=get_user_old_data($userid , 'subid');    

        $subjectsids=add_remove_array_converintostring($oldsubjects,$newsubjects_ids);

$Type_sql="";

foreach($subjectsids as $val){

$ddd="`type` ='$Type' ,";

$Type.=implode('*','1,2,3');

}



$UPSQL="UPDATE `user` SET  `subid`='$subjectsids' ,".$Type_sql." `csid`='$courseids'  WHERE `user_id`='$userid' ";

  $data=mysqli_query($mysqli,$UPSQL);

      if(mysqli_affected_rows($mysqli)>0){

    	$res.="Record Update successfully";

    	}else{

    	$res.="Record Not Any update";

    	}

    

}else{

    $res="User not found in our record";

}    

return $res;

}

function Insertwith_lastid($table, $data){



    global $mysqli;

    //print_r($data);



    $fields = array_keys( $data );  

    $values = array_map( array($mysqli, 'real_escape_string'), array_values( $data ) );

    

   //echo "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');";

   //exit;  

    mysqli_query($mysqli, "INSERT INTO $table(".implode(",",$fields).") VALUES ('".implode("','", $values )."');") or die( mysqli_error($mysqli) );

    $lastid=mysqli_insert_id($mysqli);

    if($lastid){

    return $lastid;

    }

        

    }



// Update Data, Where clause is left optional

function Update($table_name, $form_data, $where_clause='')
{   

    global $mysqli;

    // check for optional where clause

    $whereSQL = '';

    if(!empty($where_clause))

    {

        // check to see if the 'where' keyword exists

        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')

        {

            // not found, add key word

            $whereSQL = " WHERE ".$where_clause;

        } else

        {

            $whereSQL = " ".trim($where_clause);

        }

    }

    // start the actual SQL statement

    $sql = "UPDATE ".$table_name." SET ";



    // loop and build the column /

    $sets = array();

    foreach($form_data as $column => $value)
    {

         $sets[] = "`".$column."` = '".$value."'";

    }

    $sql .= implode(', ', $sets);

    // append the where statement

    $sql .= $whereSQL;

        //  echo $sql;die;

    // run and return the query result

    return mysqli_query($mysqli,$sql);

}



 

//Delete Data, the where clause is left optional incase the user wants to delete every row!

function Delete($table_name, $where_clause='')

{   

    global $mysqli;

    // check for optional where clause

    $whereSQL = '';

    if(!empty($where_clause))

    {

        // check to see if the 'where' keyword exists

        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')

        {

            // not found, add keyword

            $whereSQL = " WHERE ".$where_clause;

        } else

        {

            $whereSQL = " ".trim($where_clause);

        }

    }

    // build the query

    $sql = "DELETE FROM ".$table_name.$whereSQL;

     

    // run and return the query result resource

    return mysqli_query($mysqli,$sql);

}  

 

//GCM function

function Send_GCM_msg($registration_id,$data)

{

    $data1['data']=$data;

 

    $url = 'https://fcm.googleapis.com/fcm/send';

  

    $registatoin_ids = array($registration_id);

     // $message = array($data);

   

         $fields = array(

             'registration_ids' => $registatoin_ids,

             'data' => $data1,

         );

  

         $headers = array(

             'Authorization: key='.APP_GCM_KEY.'',

             'Content-Type: application/json'

         );

         // Open connection

         $ch = curl_init();

  

         // Set the url, number of POST vars, POST data

         curl_setopt($ch, CURLOPT_URL, $url);

  

         curl_setopt($ch, CURLOPT_POST, true);

         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  

         // Disabling SSL Certificate support temporarly

         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  

         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

  

         // Execute post

         $result = curl_exec($ch);

         if ($result === FALSE) {

             die('Curl failed: ' . curl_error($ch));

         }

  

         // Close connection

         curl_close($ch);

       //echo $result;exit;

}





//Image compress

function compress_image($source_url, $destination_url, $quality) 

{



    $info = getimagesize($source_url);



        if ($info['mime'] == 'image/jpeg')

              $image = imagecreatefromjpeg($source_url);



        elseif ($info['mime'] == 'image/gif')

              $image = imagecreatefromgif($source_url);



      elseif ($info['mime'] == 'image/png')

              $image = imagecreatefrompng($source_url);



        imagejpeg($image, $destination_url, $quality);

    return $destination_url;

}



//Create Thumb Image

function create_thumb_image($target_folder ='',$thumb_folder = '', $thumb_width = '',$thumb_height = '')

 {  

     //folder path setup

         $target_path = $target_folder;

         $thumb_path = $thumb_folder;  

          



         $thumbnail = $thumb_path;

         $upload_image = $target_path;



            list($width,$height) = getimagesize($upload_image);

            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);

            switch($file_ext){

                case 'jpg':

                    $source = imagecreatefromjpeg($upload_image);

                    break;

                case 'jpeg':

                    $source = imagecreatefromjpeg($upload_image);

                    break;

                case 'png':

                    $source = imagecreatefrompng($upload_image);

                    break;

                case 'gif':

                    $source = imagecreatefromgif($upload_image);

                     break;

                default:

                    $source = imagecreatefromjpeg($upload_image);

            }

       imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width,$height);

            switch($file_ext){

                case 'jpg' || 'jpeg':

                    imagejpeg($thumb_create,$thumbnail,80);

                    break;

                case 'png':

                    imagepng($thumb_create,$thumbnail,80);

                    break;

                case 'gif':

                    imagegif($thumb_create,$thumbnail,80);

                     break;

                default:

                    imagejpeg($thumb_create,$thumbnail,80);

            }

 }


  function upload_img($path = null, $image = null) {
		
    $res = array("error" => true, 'msg' => 'Unable to upload.');
    try {
        list($type, $image) = explode(';', $image);
        list(, $extension) = explode('/', $type);
        list(, $image) = explode(',', $image);
        $fileName = uniqid() . generateRandomString() . '.' . $extension;
        $image = base64_decode($image);
        file_put_contents($path . $fileName, $image);
        $res['error'] = false;
        $res['msg'] = '';
        $res['name'] = $fileName;
    } catch (Exception $e) {
    }
    return $res;
}

 function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . '/admin';
}


function getUserdetail($userid)
{
    global $mysqli;
    $sql = "SELECT * FROM users where id = '".$userid."'"; 
    $result = mysqli_query($mysqli, $sql);
    $row = $result->fetch_assoc();
    return $row;

}

function removeHtml($replace,$text)
{
    return str_replace($replace,'',$text);


}

function getSloContents($lesson_id) {
    global $mysqli;

    $sloContents = array();

    $sql = "SELECT * FROM lesson_plan_content WHERE lesson_plan_id = '$lesson_id'";
    $result = mysqli_query($mysqli, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $sloContents[] = array(
            'id' => $row['id'],
            'slo_content' => $row['slo_content'],
            'method' => $row['method'],
            'time_allotted' => $row['time_allotted'],
            'resource_provided' => $row['resource_provided'],
        );
    }

    return $sloContents;
}

?>