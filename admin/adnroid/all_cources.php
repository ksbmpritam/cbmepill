<?php
 include("db.php");
    $response = array();
 $query = "SELECT * FROM `cource` ";
$dept = mysqli_query($con, $query);
if(mysqli_num_rows($dept)>0){
    while ($row = mysqli_fetch_assoc($dept))
    {
        $row['icon']="angirasuratgarhlive.com/ksbmadmin/upload/banner/".$row['icon'];
        array_push($response,$row);
    }
}

echo json_encode($response);
?>
