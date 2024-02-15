<?php
include("db.php");


if(! empty($_POST['name'])  &&  ! empty($_POST['email'])   &&  ! empty($_POST['phone']) &&   ! empty($_POST['message'])   )
{
    
     
    $name=$_POST['name'];
    $email=$_POST['email'];
    $msg=$_POST['message'];
  $phone=$_POST['phone'];
    
    $sql='INSERT INTO `contact`(`name`, `email`, `phone`, `msg`) VALUES ("'.$name.'","'.$email.'","'.$phone.'","'.$msg.'")';
    $query=mysqli_query($con,$sql);
    
    if($query){
        
       $response['response']="0"; 
        $response['message']="success"; 
       echo json_encode($response);
    }
    
    
    
    
}else{
    
      $response['response']="1"; 
        $response['message']="error"; 
       echo json_encode($response);
}


?>