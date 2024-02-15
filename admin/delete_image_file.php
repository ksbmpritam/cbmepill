<?php
require ("includes/function.php");
$id = filter($_GET['id']);

$sql = "UPDATE `slides` set image='' WHERE id='$id'";

if(mysqli_query($mysqli,$sql)){
    echo "success";
}else{
    echo "error";
}

?>