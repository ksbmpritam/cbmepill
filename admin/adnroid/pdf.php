<?php

include("db.php");
if (isset($_POST['subject_wise_videos']) && isset($_POST['user_id']) && isset($_POST['course_id'])) {
    $query = mysqli_query($con, "select * from user where user_id='" . $_POST['user_id'] . "'");
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['paid'] == '1') {
            $type = explode(' ', $row['type']);
            $csid = explode(' ', $row['subid']);
            $i = 0;
//            foreach ($csid as $val) {
                $csid1 = explode(',', $csid[$i]);
                $type1 = explode(',', $type[$i]);
                $courseid = explode(' ', $row['csid']);
                $courseid1 = explode(',', $courseid[$i]);
//                foreach ($csid1 as $val1) {
//                    if ($val1 == $_POST['subject_wise_videos']) {
                    if (in_array($_POST['course_id'], $courseid1)) {
//                        foreach ($type1 as $val2) {
//                            if ($val2 == '2') {

                                $jsonObj = array();
// 		$cat_order=API_CAT_ORDER_BY;
                                $url = 'http://angirasuratgarhlive.com/ksbmadmin/infotrade/images/';
                                $pd_url = 'http://angirasuratgarhlive.com/ksbmadmin/uploads/';
                                $query = "SELECT tbl_pdf.* ,concat('http://angirasuratgarhlive.com/ksbmadmin/pdf/',pdf) as pdf FROM tbl_pdf where cat_id='" . $_POST['course_id'] . "' AND subject_id = '" . $_POST['subject_wise_videos'] . "' order by rangee ASC";
                                $sql = mysqli_query($con, $query)or die(mysql_error());
                                while ($data = mysqli_fetch_assoc($sql)) {
                                    $data['featured_pdf'] = '0';
                                    array_push($jsonObj, $data);
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
                $url = 'http://angirasuratgarhlive.com/ksbmadmin/infotrade/images/';
                $query = "SELECT tbl_pdf.*,concat('http://angirasuratgarhlive.com/ksbmadmin/pdf/',pdf) as pdf  FROM tbl_pdf where  cat_id='" . $_POST['course_id'] . "' AND  subject_id = '" . $_POST['subject_wise_videos'] . "' 
		          order by rangee ASC";
                $sql = mysqli_query($con, $query)or die(mysql_error());
                while ($data = mysqli_fetch_assoc($sql)) {
                    array_push($jsonObj, $data);
                }

                $set['VIDEO_CAT'] = $jsonObj;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            die();
        } else {
            $jsonObj = array();
// 		$cat_order = API_CAT_ORDER_BY;
            $url = 'http://angirasuratgarhlive.com/ksbmadmin/infotrade/images/';
            $query = "SELECT tbl_pdf.*,concat('http://angirasuratgarhlive.com/ksbmadmin/pdf/',pdf) as pdf FROM tbl_pdf where  cat_id='" . $_POST['course_id'] . "' AND  subject_id = '" . $_POST['subject_wise_videos'] . "' 
		          order by rangee ASC";
            $sql = mysqli_query($con, $query)or die(mysql_error());
            while ($data = mysqli_fetch_assoc($sql)) {
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