<?php
require ("includes/function.php");
$id = filter($_GET['id']);

$data = "";

$sql = "SELECT * FROM `lesson_plan` WHERE sub_categories_id='$id'";
$query = mysqli_query($mysqli,$sql);

if(mysqli_num_rows($query) > 0){
        $data .= "<option value=''> --Select Lesson Plan -- </option>";
    while($row = mysqli_fetch_assoc($query)){
        $data .= "<option value='".$row['id']."'>".$row['topics']."</option>";
    }
    echo $data;
}else{
    echo "<option value=''>No Lesson Plan Availble</option>";
}




?>