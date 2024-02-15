<?php

include("db.php");
$response = array();
file_get_contents('php://input');
//course id = subject_id
if (isset($_REQUEST['subject_id']) && isset($_REQUEST['user_id']) && isset($_REQUEST['page'])) {
    $subject_id = $_POST['subject_id'];
    $user_id = $_POST['user_id'];
    $page = $_POST['page'];


    // $subject_id=$_GET['subject_id'];
    // $user_id=$_GET['user_id'];
    // $page=$_GET['page'];


    if ($page == '1') {
        $query = mysqli_query($con, "select subid,csid from user where user_id='" . $_POST['user_id'] . "'");

        if (mysqli_num_rows($query) > 0) {
            //while($row=mysqli_fetch_assoc($query)){
            $row = mysqli_fetch_assoc($query);
            $subid = explode(',', $row['subid']);
            $csid = explode(',', $row['csid']);
            $i = 0;

            foreach ($csid as $val) {

                if ($val == $_POST['subject_id']) {
                    $subid[$i];
                    if (strstr($subid[$i], ',')) {
                        $subid = explode(',', $subid[$i]);
                        //   $subid=explode(' ',$subid[$i],2);
                    }

//                    foreach ($subid as $val) {
//                        $arr = explode(" ", $val);

//                        foreach ($arr as $v) {

                            $query = "SELECT * FROM  subject WHERE course_id ='" . $_POST['subject_id'] . "'";
                            $dept = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_assoc($dept)) {
                                $row['desc'] = strip_tags($row['desc']);
                                $row['category_image'] = "http://angirasuratgarhlive.com/ksbmadmin/images/" . $row['subject_image'];
                                array_push($response, $row);
                            }
//                        }
//                    }
                }
                $i++;
            }
        }
        echo json_encode(array("result" => $response));
    } else {

        $query = "SELECT * FROM  subject WHERE course_id ='$subject_id'";
        $dept = mysqli_query($con, $query);



        $sqls = "SELECT `subject_des`,`subject_image` FROM `tbl_category` WHERE `cid`='$subject_id'";
        $query = mysqli_query($con, $sqls);
        $rows = mysqli_fetch_assoc($query);

        $rows['banner_image'] = "http://angirasuratgarhlive.com/ksbmadmin/" . $rows['subject_image'];
        //$rows['category_image']='http://angirasuratgarhlive.com/images/5086_vedic-period-indian-history.png';
        $data = $rows;
        while ($row = mysqli_fetch_assoc($dept)) {
            $row['desc'] = strip_tags($row['desc']);
            $row['category_image'] = "http://angirasuratgarhlive.com/ksbmadmin/images/" . $row['subject_image'];
            // $row['category_image']='http://angirasuratgarhlive.com/images/5086_vedic-period-indian-history.png';
            array_push($response, $row);
        }


        echo json_encode(array("result" => $response));
    }
} else {
    $response = 'invalid';
    echo json_encode(array("result" => $response));
}
?>
