<?php
/*
error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

    //set your folder path
    $video_local="uploads/".rand(0,99999)."_".str_replace(" ", "-", $_FILES['video_local']['name']);

    $tmp = $_FILES['video_local']['tmp_name'];  
    if (move_uploaded_file($tmp,$video_local)) 
    { 
        echo $video_local;
    } else {
        echo "failed";
    }
    exit;
}
*/
$upload = 'err'; 
$message='';
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
     
    // File upload configuration 
    $video_local ="uploads/".rand(0,99999)."_".str_replace(" ", "-", $_FILES['video_local']['name']);
    $allowTypes = array('mp4', 'avi','x-m4v','m4v', 'wmv', 'mpg', 'mpv', 'flv', 'swf'); 
   
    // Check whether file type is valid 
    $fileType = pathinfo($video_local, PATHINFO_EXTENSION); 
    if(in_array($fileType, $allowTypes)){ 
        // Upload file to the server 
        if(move_uploaded_file($_FILES['video_local']['tmp_name'], $video_local)){
            echo $video_local;
            $upload = 'ok'; 
            //echo "File  Successfully Upload !";
        } 
        else {
        echo "Oops ! failed dont upload !";
        }
        
    }
    else
    {
       //$message="Failed ! File formate is not MP4";
       echo "OOps ! file type not a video type !";
    }
} 
// echo $message;