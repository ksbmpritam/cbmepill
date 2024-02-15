<?php

include("db.php");
if (isset($_POST['subject_wise_pdf']) && isset($_POST['user_id']) && isset($_POST['course_id'])) {
    $staff_query = '';
    $query = mysqli_query($con, "select * from user where user_id='" . $_POST['user_id'] . "'");
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['is_staff'] != '1') {
            $staff_query = " AND is_published='1' ";
        } else {
            $staff_query = "";
            
        }
        if ($row['paid'] == '1') {
            $type = explode(' ', $row['type']);
            $csid = explode(' ', $row['subid']);
            $courseid = explode(' ', $row['csid']);
            $i = 0;

//            foreach ($csid as $val) {
                $csid1 = explode(',', $csid[$i]);
                $courseid1 = explode(',', $courseid[$i]);

                if (strstr($type[$i], ',')) {
                    $type1 = explode(',', $type[$i]);
                } else {
                    $type1 = explode('*', $type[$i]);
                }

//                foreach ($csid1 as $val1) {

//                    if ($val1 == $_POST['subject_wise_pdf']) {
                    if (in_array($_POST['course_id'], $courseid1)) {



//                        foreach ($type1 as $val2) {

//                            if ($val2 == '3') {

                                $jsonObj = array();
// 		$cat_order=API_CAT_ORDER_BY;
                                $query = "SELECT *  FROM exam where courseid='" . $_POST['course_id'] . "' AND  subjectid = '" . $_POST['subject_wise_pdf'] . "' $staff_query order  by rangee asc";
                                $sql = mysqli_query($con, $query)or die(mysql_error());
                                while ($data = mysqli_fetch_assoc($sql)) {
                                    $data['mcq_name'] = $data['name'];
                                    $data['featured_mcq'] = '0';
                                    $data['thambnail'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/logo.png';
                                    array_push($jsonObj, $data);
                                    //	print_r($data);
                                }

                                $set['VIDEO_CAT'] = $jsonObj;
//                            }
//                        }
                    }
//                }
                $i++;
//            }
            if (empty($set)) {

                $jsonObj = array();
// 		$cat_order=API_CAT_ORDER_BY;
                $query = "SELECT *  FROM exam where  courseid='" . $_POST['course_id'] . "' AND  subjectid = '" . $_POST['subject_wise_pdf'] . "' 
		          $staff_query order  by rangee asc";
                $sql = mysqli_query($con, $query)or die(mysql_error());
                while ($data = mysqli_fetch_assoc($sql)) {
                    $data['mcq_name'] = $data['name'];
                    $data['thambnail'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/logo.png';
                    array_push($jsonObj, $data);
                }

                $set['VIDEO_CAT'] = $jsonObj;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            die();
        } else {
            $jsonObj = array();
// 		$cat_order=API_CAT_ORDER_BY;
            $query = "SELECT * FROM exam where  courseid='" . $_POST['course_id'] . "' AND  subjectid = '" . $_POST['subject_wise_pdf'] . "' 
		           $staff_query order  by rangee asc";
            $sql = mysqli_query($con, $query)or die(mysql_error());
            while ($data = mysqli_fetch_assoc($sql)) {
                $data['mcq_name'] = $data['name'];
                $data['thambnail'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/logo.png';
                array_push($jsonObj, $data);
            }
            $set['VIDEO_CAT'] = $jsonObj;

            header('Content-Type: application/json; charset=utf-8');
            echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            die();
        }
    }
}
?>