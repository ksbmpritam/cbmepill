<?php
require ("includes/function.php");
$id = filter($_GET['id']);

$data = "";

$sql = "SELECT * FROM `lesson_plan_content` WHERE lesson_plan_id='$id'";
$query = mysqli_query($mysqli,$sql);

if(mysqli_num_rows($query) > 0){
        $data .= "<option value=''> --Select SLO Content -- </option>";
    while($row = mysqli_fetch_assoc($query)){
        $data .= "<option value='".$row['id']."'>".$row['slo_content']."</option>";
    }
    echo $data;
}else{
    echo "<option value=''>No SLO Content Availble</option>";
}




?>