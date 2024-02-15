<?php
require ("includes/function.php");
$id = filter($_GET['id']);
$teacherId = $_SESSION['teacher_id'] ?? 58;

$data = "";

$sql = "SELECT id,category_id,name FROM `sub_categories` WHERE category_id='$id' AND teacher_id = $teacherId";
$query = mysqli_query($mysqli,$sql);

if(mysqli_num_rows($query) > 0){
    $data .= "<option value=''> --Select Sub Category -- </option>";
    while($row = mysqli_fetch_assoc($query)){
        $data .= "<option value='".$row['id']."'>".$row['name']."</option>";
    }
    echo $data;
}else{
    echo "<option value=''>No Sub Category Availble</option>";
}




?>