<?php
require ("includes/function.php");
$id = filter($_GET['id']);


$data = "";

$sql = "SELECT id,image FROM `think_higher_images` WHERE id='$id'";
$query = mysqli_query($mysqli,$sql);


if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
        $url = url()."/think_higher_images/".$row['image'];
        echo $url;
    }
}else{
    echo ".che";
}

?>