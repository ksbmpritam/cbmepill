<?php
require ("includes/function.php");
$id = filter($_GET['id']);

$data = "";

$sql = "SELECT photos FROM `game_photos` WHERE id='$id'";
$query = mysqli_query($mysqli,$sql);

if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
        $url = url()."/games_photos/".$row['photos'];
        echo $url;
    }
}else{
    echo ".vish";
}

?>