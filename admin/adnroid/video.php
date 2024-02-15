<?php

include("db.php");


// mysqli_query('SET character_set_results=utf8');
// mysqli_query('SET names=utf8');
// mysqli_query('SET character_set_client=utf8');
// mysqli_query('SET character_set_connection=utf8');
// mysqli_query('SET character_set_results=utf8');
// mysqli_query('SET collation_connection=utf8_general_ci');


if (isset($_POST['subject_wise_videos']) && isset($_POST['user_id']) && isset($_POST['course_id'])) {
    $query = mysqli_query($con, "select * from user where user_id='" . $_POST['user_id'] . "'");
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['paid'] == '1') { //check if paid
            $type = explode(' ', $row['type']); // get types(mcq,video,book)
            $csid = explode(' ', $row['subid']); // get course ids
            $courseid = explode(' ', $row['csid']);
            $i = 0;
//            foreach ($csid as $val) {
                $csid1 = explode(',', $csid[$i]);
                $type1 = explode(',', $type[$i]);
                $courseid1 = explode(',', $courseid[$i]);
//                foreach ($csid1 as $val1) {
//                    if ($val1 == $_POST['subject_wise_videos']) {
                    if (in_array($_POST['course_id'], $courseid1)) {
//                        foreach ($type1 as $val2) {
//                            if ($val2 == '1') {
                                $jsonObj = array();
                                // 		$cat_order=API_CAT_ORDER_BY;
                                $url = 'http://angirasuratgarhlive.com/ksbmadmin/images/';
                                $query = "SELECT tbl_video.*,concat('$url',video_thumbnail) as raal_thumbnail  FROM tbl_video where cat_id='" . $_POST['course_id'] . "' AND subject_id = '" . $_POST['subject_wise_videos'] . "'  order by `rangee` asc";
                                $sql = mysqli_query($con, $query)or die(mysql_error());
                                while ($data = mysqli_fetch_assoc($sql)) {
                                    $data['video_type'] = 'server_url';
                                    $data['featured_video'] = '0';
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
                $url = 'http://angirasuratgarhlive.com/ksbmadmin/';
                $query = "SELECT tbl_video.*,concat('$url',video_thumbnail) as raal_thumbnail  FROM tbl_video where cat_id='" . $_POST['course_id'] . "' AND subject_id = '" . $_POST['subject_wise_videos'] . "'  order by `rangee` asc 
            		         ";
                $sql = mysqli_query($con, $query)or die(mysql_error());
                while ($data = mysqli_fetch_assoc($sql)) {
                    $data['video_type'] = 'server_url';
                    array_push($jsonObj, $data);
                }

                $set['VIDEO_CAT'] = $jsonObj;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo $val = str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            die();
        } else { // if unpaid
            $jsonObj = array();
            //  $cat_order=API_CAT_ORDER_BY;
            $url = 'http://angirasuratgarhlive.com/ksbmadmin/';
            $query = "SELECT tbl_video.*,concat('$url',video_thumbnail) as raal_thumbnail  FROM tbl_video where cat_id='" . $_POST['course_id'] . "' AND subject_id = '" . $_POST['subject_wise_videos'] . "'  order by `rangee` asc
    		         ";
            $sql = mysqli_query($con, $query)or die(mysql_error());
            while ($data = mysqli_fetch_assoc($sql)) {
                $data['video_type'] = 'server_url';
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