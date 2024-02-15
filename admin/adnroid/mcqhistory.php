<?php

include("db.php");
if ($_POST['user_id'] != '') {
    mysqli_set_charset($con, "utf8");
    $output1 = array();
    $output = array();
    $data = array();
    $query = mysqli_query($con, "SELECT DISTINCT(`track`),exam_id FROM `result` WHERE `user_id`='" . $_POST['user_id'] . "' order by `track` DESC");
    if (mysqli_num_rows($query) > 0) {
        while ($row3 = mysqli_fetch_assoc($query)) {
            $output1[] = $row3;
        }
    }

    foreach ($output1 as $result) {

        $query = "SELECT q.Question as question,q.answer as correct_answer,r.user_answer,"
                . "q.option_1,q.option_2,q.option_3,q.option_4,r.Percentage,r.datetime "
                . "from result as r LEFT JOIN question as q ON q.id = r.q_id "
                . "where r.user_id='" . $_POST['user_id'] . "' and r.exam_id='" . $result['exam_id'] . "' and r.track='" . $result['track'] . "'";
//        $query = mysqli_query($con, "select question,correct_answer,user_answer,option_1,option_2,option_3,option_4,Percentage,datetime from result where user_id='" . $_POST['user_id'] . "' and exam_id='" . $result['exam_id'] . "' and track='" . $result['track'] . "' ");
        $query = mysqli_query($con, $query);
        $count = mysqli_num_rows($query);
        $i = 0;
        $right = 0;
        $date = '0';
        $wrong = 0;
        $skipped = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            if($row['user_answer'] != ""){
                if ($row['correct_answer'] != $row['user_answer']) {
                    $wrong++;
                }
            } else {
                $skipped++;
            }
            if ($row['correct_answer'] != '') {
                if ($row['correct_answer'] == $row['user_answer']) {
                    $i++;
                    $right = $i;
                }  
                if ($row['correct_answer'] == 'A') {
                    $row['correct_answer'] = $row['option_1'];
                }
                if ($row['correct_answer'] == 'B') {
                    $row['correct_answer'] = $row['option_2'];
                }
                if ($row['correct_answer'] == 'C') {
                    $row['correct_answer'] = $row['option_3'];
                }
                if ($row['correct_answer'] == 'D') {
                    $row['correct_answer'] = $row['option_4'];
                }
            }
            
            
            $row1['question'] = $row['question'];
            $row1['user_answer'] = $row['user_answer'];
            $row1['correct_answer'] = $row['correct_answer'];
            $date = $row['datetime'];
            $output[] = $row1;
        }

        $reper = (($right * 100) / $count);

        $reper = number_format($reper,2);

        if ($reper < 75 && 60 <= $reper) {
            $text = "Average Student";
            $img = 'http://www.appcreator.co.in/infotrade/images/smily/smily.png';
        } elseif ($reper < 60 && 40 <= $reper) {
            $text = "Good You Have To Work More Hard";
            $img = 'http://www.appcreator.co.in/infotrade/images/smily/smily.png';
        } elseif ($reper < 40 && 33 <= $reper) {
            $text = "You Have To Practive More nad more";
            $img = 'http://www.appcreator.co.in/infotrade/images/smily/smily.png';
        } elseif ($reper < 33) {
            $text = "Faild";
            $img = 'http://www.appcreator.co.in/infotrade/images/smily/sad.png';
        } else {
            $text = "Congratulation";
            $img = 'http://www.appcreator.co.in/infotrade/images/smily/smily.png';
        }

        $query34 = mysqli_query($con, "select name from exam where id='" . $result['exam_id'] . "'");
        if (mysqli_num_rows($query34) > 0) {
            $name = mysqli_fetch_assoc($query34);
            $name = $name['name'];
        } else {
            $name = 'Demo';
        }
//        $wrong = $count - $right;
        $vicky['user_id'] = $_POST['user_id'];
        $vicky['exam_id'] = $result['exam_id'];
        $vicky['track'] = $result['track'];
        $vicky['name'] = $name;
        $vicky['total'] = "$count";
        $vicky['right'] = "$right";
        $vicky['wrong'] = "$wrong";
        $vicky['skip'] = "$skipped";
        $vicky['image'] = $img;
        $vicky['percentage'] = $reper . '%';
        $vicky['Text'] = $text;
        $date = strtotime($date);
        $vicky['date'] = date('d-m-Y', $date);
        $data[] = $vicky;
    }
    echo json_encode(array("status" => "1", "Response" => array_reverse($data)));
} else {
    echo json_encode(array("status" => "0", "response" => "Please Fill All Field"));
}
?>