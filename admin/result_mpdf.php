<?php

include("includes/connection.php");
require("includes/function.php");

global $mysqli;
// start the actual SQL statement
mysqli_set_charset($mysqli, 'utf8');
$result_id = (isset($_GET['id']) && $_GET['id'] > 0) ? $_GET['id'] : '';

$sqli = "SELECT * from result where id=$result_id";
$data = mysqli_query($mysqli, $sqli);
$result = mysqli_fetch_assoc($data);


$result_array = [];
$total = 0;
$right = 0;
$wrong = 0;
$skipped = 0;
$marks = 0;
$frommarks = 0;
if (!empty($result)) {
    $track = isset($result['track']) ? $result['track'] : "";
    $user_id = isset($result['user_id']) ? $result['user_id'] : "";
    $exam_id = isset($result['exam_id']) ? $result['exam_id'] : "";

    $sqli = "SELECT * from exam where id=$exam_id";
    $data = mysqli_query($mysqli, $sqli);
    $exam = mysqli_fetch_assoc($data);


    $sqli = "SELECT r.id,q.answer as correct_answer,r.user_answer,r.q_id,r.exam_id,r.user_id,"
            . "q.Question,q.option_1,q.option_2,q.option_3,q.option_4,q.points,q.is_negative,q.negative_points,"
            . "q.image,q.image_opt1,q.image_opt2,q.image_opt3,q.image_opt4 "
            . "from result as r LEFT JOIN question as q ON q.id = r.q_id "
            . "where r.track='$track' and r.user_id='$user_id' and r.exam_id='$exam_id' order by q.id";
    $query = mysqli_query($mysqli, $sqli);
    $results = mysqli_fetch_all($query, MYSQLI_ASSOC);

    foreach ($results as $key => $res) {

        if ($res['correct_answer'] == $res['user_answer']) {
            $right++;
            $marks += $res['points'];
        } else if ($res['user_answer'] === '0' || $res['user_answer'] === 0 || $res['user_answer'] == "") {
            $skipped++;
        } else {
            $wrong++;
            if ($res['is_negative'] == 1) {
                $marks = $marks - $res['negative_points'];
            }
        }
        $frommarks += $res['points'];
        $total++;

        $result_array[] = $res;
    }
}
// Include the main TCPDF library (search for installation path).

require_once 'mpdf/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8',
//    'default_font_size' => 9,
	'default_font' => 'freesans']);


$html = '';

//$mpdf->SetFont('freesans', '');
$html .= '<center style="text-align:center;"><img src="images/logo.png" height="50" width="100"/></center>';

$mpdf->WriteHTML($html);

$examName = isset($exam['name']) ? $exam['name'] : "";
$html = '<div style="text-align:center;"><h1>' . $examName . '</h1>'
        . '<h6>(Total Questions : ' . $total . ' &emsp;&emsp;&emsp; Right Answer : ' . $right . ' &emsp;&emsp;&emsp; Wrong Answer : ' . $wrong . ' &emsp;&emsp;&emsp; Skipped Answer : ' . $skipped . ')</h6>'
        . '<h6>(Total Marks : ' . $marks . '/' . $frommarks . ')</h6></div>';

$mpdf->WriteHTML($html);

$html = "";

foreach ($result_array as $key => $value) {


    $option_1 = $value['correct_answer'] == "A" ? "color:green" : ($value['user_answer'] == "A" ? "color:red;" : "");
    $option_2 = $value['correct_answer'] == "B" ? "color:green" : ($value['user_answer'] == "B" ? "color:red;" : "");
    $option_3 = $value['correct_answer'] == "C" ? "color:green" : ($value['user_answer'] == "C" ? "color:red;" : "");
    $option_4 = $value['correct_answer'] == "D" ? "color:green" : ($value['user_answer'] == "D" ? "color:red;" : "");

    $skipped = "(Skipped)";
    if ($value['user_answer']) {
        $skipped = "";
    }
    if ($value['image_opt1'] != "" && $value['image_opt2'] != "" && $value['image_opt3'] != "" && $value['image_opt4'] != "") {

        $html .= '<h4>Q' . ($key + 1) . '. ' . $value['Question'] . '&emsp;(Marks : ' . $value['points'] . ') '.$skipped.'</h4>
        <ul>
                <li style="' . $option_1 . '"><b>A.</b> <a href="images/ExamAns/' . $value['image_opt1'] . '" target="_blank">http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $value['image_opt1'] . '</a></li>
                <li style="' . $option_2 . '"><b>B.</b> <a href="images/ExamAns/' . $value['image_opt2'] . '" target="_blank">http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $value['image_opt2'] . '</a></li>
                <li style="' . $option_3 . '"><b>C.</b> <a href="images/ExamAns/' . $value['image_opt3'] . '" target="_blank">http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $value['image_opt3'] . '</a></li>
                <li style="' . $option_4 . '"><b>D.</b> <a href="images/ExamAns/' . $value['image_opt4'] . '" target="_blank">http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $value['image_opt4'] . '</a></li>
        </ul>';
    } else {

        $html .= '<h4>Q' . ($key + 1) . '. ' . $value['Question'] . '&emsp;(Marks : ' . $value['points'] . ') '.$skipped.'</h4>
        <ul>
                <li style="' . $option_1 . '"><b>A.</b> ' . strip_tags($value['option_1']) . '</li>
                <li style="' . $option_2 . '"><b>B.</b> ' . strip_tags($value['option_2']) . '</li>
                <li style="' . $option_3 . '"><b>C.</b> ' . strip_tags($value['option_3']) . '</li>
                <li style="' . $option_4 . '"><b>D.</b> ' . strip_tags($value['option_4']) . '</li>
        </ul>';
    }
}

$mpdf->autoScriptToLang = true;
$mpdf->baseScript = 1;
$mpdf->autoVietnamese = true;
$mpdf->autoArabic = true;

$mpdf->autoLangToFont = true;

$mpdf->WriteHTML($html);

$mpdf->Output();
