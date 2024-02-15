<?php
require ("includes/function.php");
$id = filter($_GET['id']);

$sql = "DELETE FROM `games_pills` WHERE id='$id'";

if(mysqli_query($mysqli,$sql)){
    echo "success";
    header("location:all_asign_pills.php");
}else{
    echo "error";
}

?>