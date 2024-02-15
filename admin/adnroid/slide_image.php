<?php
 include("db.php");
    $response = array();
//echo "ok";die;
//	mysql_set_charset("utf8");
    //$result = mysqli_query($con,"select * from cource");
 $query = "SELECT * FROM  slider_image";
 $dept = mysqli_query($con, $query);



    while ($row = mysqli_fetch_array($dept))
    {
      
        $row['image_name']="http://angirasuratgarhlive.com/ksbmadmin/images/".$row['image'];
        array_push($response,$row);
    }


echo json_encode($response);
?>
