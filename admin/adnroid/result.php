<?php

include'db.php';
$json = file_get_contents("php://input");
// print_r($json); die;
$obj = json_decode($_POST['data']);
// print_r($obj); die;
mysqli_set_charset($con, 'utf8');
if ($_POST['data'] != '' && $_POST['user_id'] != '' && $_POST['exam_id'] != '' && $_POST['Percentage'] != '') {
    $output = array();
    $getids = mysqli_query($con, "select track from result where user_id='" . $_POST['user_id'] . "' and exam_id='" . $_POST['exam_id'] . "' order by id desc limit 1");
    if (mysqli_num_rows($getids) > 0) {
        $sd = mysqli_fetch_assoc($getids);
        $trackid = $sd['track'];
        $trackid++;
    } else {
        $trackid = 'HIGHER000001';
    }


    foreach ($obj as $data) {
        $sql = "select * from question where id = " . $data->{'q_id'};

        $sqli = mysqli_query($con, $sql);
        $que_detail = mysqli_fetch_assoc($sqli);

        $query = mysqli_query($con, 'INSERT INTO `result`(`question`, `option_1`, `option_2`, `option_3`, `option_4`, `correct_answer`,  `user_answer`, `q_id`, `exam_id`, `user_id`, `date`,`track`,`Percentage`,`image`) VALUES '
                . '('
                . '"' . strip_tags($que_detail['Question']) . '",'
                . '"' . strip_tags($que_detail['option_1']) . '",'
                . '"' . strip_tags($que_detail['option_2']) . '",'
                . '"' . strip_tags($que_detail['option_3']) . '",'
                . '"' . strip_tags($que_detail['option_4']) . '",'
                . '"' . strip_tags($que_detail['answer']) . '",'
                . '"' . strip_tags($data->{'user_answer'}) . '",'
                . '"' . $data->{'q_id'} . '",'
                . '"' . $_POST['exam_id'] . '",'
                . '"' . $_POST['user_id'] . '",'
                . '"' . date("d-m-Y") . '",'
                . '"' . $trackid . '",'
                . '"' . $_POST['Percentage'] . '",'
                . '"' . $que_detail['image'] . '")');
    }

    if ($query) {

        $query = mysqli_query($con, "select q_id, question,correct_answer,user_answer,option_1,option_2,option_3,option_4,Percentage,image from result where user_id='" . $_POST['user_id'] . "' and exam_id='" . $_POST['exam_id'] . "' and track='$trackid' ");
        $count = mysqli_num_rows($query);

        $i = 0;
        $j = 0;
        $k = 0;
        $right = 0;
        $wrong = 0;
        $skip = 0;
        $attempted = 0;
        $points = 0;
        $negative_points = 0;
        $attemptedpoints = 0;
        $q = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            //   if($row['correct_answer']!='')
            //   {
            //       if($row['correct_answer']=='A')
            //       {
            //           $row['correct_answer']=$row['option_1'];
            //       }
            //       if($row['correct_answer']=='B')
            //       {
            //           $row['correct_answer']=$row['option_2'];
            //       }
            //       if($row['correct_answer']=='C')
            //       {
            //           $row['correct_answer']=$row['option_3'];
            //       }
            //       if($row['correct_answer']=='D')
            //       {
            //           $row['correct_answer']=$row['option_4'];
            //       }
            $row1 = $row;

            $sql = "select * from question where id = " . $row1['q_id'];

            $sqli = mysqli_query($con, $sql);
            $ques_detail = mysqli_fetch_assoc($sqli);
            $is_skipped = 0;
            $attemptedpoints += $ques_detail['points'];
            if ($row['user_answer'] === '0' || $row['user_answer'] === 0 || $row['user_answer'] == "") {
                $k++;
                $skip = $k;
                $is_skipped = 1;
            } else {
                $attempted++;
                if ($ques_detail['answer'] == $row['user_answer']) {
                    $i++;
                    $right = $i;
                    $points += $ques_detail['points'];
                } else {
                    $j++;
                    $wrong = $j;
                    if ($ques_detail['is_negative'] == 1) {
                        $negative_points += $ques_detail['negative_points'];
                    }
                }
            }
            //   }





            $row1['question'] = $ques_detail['Question'];
            $row1['option_1'] = $ques_detail['option_1'];
            $row1['option_2'] = $ques_detail['option_2'];
            $row1['option_3'] = $ques_detail['option_3'];
            $row1['option_4'] = $ques_detail['option_4'];
            if ($ques_detail['image'] != '') {
                $row1['image'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $ques_detail['image'];
            }

            if ($ques_detail['image_opt1'] != '') {
                $row1['image_opt1'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $ques_detail['image_opt1'];
            } else {
                $row1['image_opt1'] = '';
            }
            if ($ques_detail['image_opt2'] != '') {
                $row1['image_opt2'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $ques_detail['image_opt2'];
            } else {
                $row1['image_opt2'] = '';
            }
            if ($ques_detail['image_opt3'] != '') {
                $row1['image_opt3'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $ques_detail['image_opt3'];
            } else {
                $row1['image_opt3'] = '';
            }
            if ($ques_detail['image_opt4'] != '') {
                $row1['image_opt4'] = 'http://angirasuratgarhlive.com/ksbmadmin/images/ExamAns/' . $ques_detail['image_opt4'];
            } else {
                $row1['image_opt4'] = '';
            }

            $row1['user_answer'] = $row['user_answer'];
            $row1['correct_answer'] = $ques_detail['answer'];
            $row1['images'] = $row['image'];
            $row1['skip'] = $is_skipped;
            $output[$q] = $row1;
            $q++;
        }
//        $total = $right - ($wrong * 0.25);
        $total = $points - $negative_points;

        $reper = intVal(($total * 100) / $count);

        if ($reper < 75 && 60 <= $reper) {
            $text = "Average Student";
            $img = 'http://angirasuratgarhlive.com/ksbmadmin/images/smily/smile.png';
        } elseif ($reper < 60 && 40 <= $reper) {
            $text = "Good You Have To Work More Hard";
            $img = 'http://angirasuratgarhlive.com/ksbmadmin/images/smily/smile.png';
        } elseif ($reper < 40 && 33 <= $reper) {
            $text = "You Have To Practive More";
            $img = 'http://angirasuratgarhlive.com/ksbmadmin/images/smily/smile.png';
        } elseif ($reper < 33) {
            $text = "Failed";
            $img = 'http://angirasuratgarhlive.com/ksbmadmin/images/smily/sad.png';
        } else {
            $text = "Congratulation";
            $img = 'http://padhakuji.com/images/smily/smily.png';
        }

        if ($reper <= 0) {
            $reper = 0;
        }

        $questions_output = array_column($output, 'q_id');
        array_multisort($questions_output, SORT_ASC, $output);

        $examsql = 'SELECT * FROM `exam` WHERE `id`=' . $_POST['exam_id'];
        $resultexam = mysqli_query($con, $examsql);
        $examrow = mysqli_fetch_assoc($resultexam);
        echo json_encode(array("status" => "1", "Response" => $output, "time" => $examrow['exam_time'], "total" => count($output), "right" => $right, "image" => $img, "percentage" => $reper . '%', 'result' => $text, "wrong_ans" => $wrong, "skipped" => $skip, "attempted" => $attempted, 'total_marks' => number_format($total,2), 'from_marks' => $attemptedpoints));
    } else {
        echo json_encode(array("status" => "1", "Response" => "Data Not Inserted"));
    }
} else {
    echo json_encode(array("status" => "0", "Response" => "Please Fill All Fields"));
}


/* include'db.php';
  //print_r($_POST); die;
  $data = (array) json_decode(file_get_contents('php://input'), TRUE);
  print_r($data); die;

  $user_id=$data['user_id'];
  $exam_id=$data['exam_id'];
  $Percentage=$data['Percentage'];
  $quest_data=$data['data'];

  if($user_id=='')
  {
  echo json_encode(array("status"=>"0","Response"=>"User Id Blank"));
  }
  elseif($exam_id=='')
  {
  echo json_encode(array("status"=>"0","Response"=>"Exam id Field Blank"));
  }
  elseif($Percentage=='')
  {
  echo json_encode(array("status"=>"0","Response"=>"Percentage Field Blank"));
  }
  elseif($quest_data=='')
  {
  echo json_encode(array("status"=>"0","Response"=>"Data Field Blank"));
  }


  $output2=array();
  $output=array();
  $getids=mysqli_query($con,"select track from result where user_id='$user_id' and exam_id='$exam_id' order by id desc limit 1");
  if(mysqli_num_rows($getids)>0)
  {
  $sd=mysqli_fetch_assoc($getids);
  $trackid=$sd['track'];
  $trackid++;
  }
  else
  {
  $trackid='HIGHER000001';
  }


  $query='';
  foreach($quest_data as $data)
  {

  //mysqli_set_charset($con,"utf8");
  $con->set_charset("utf8");
  $sql='INSERT INTO `result`(`question`, `option_1`, `option_2`, `option_3`, `option_4`, `correct_answer`,  `user_answer`, `q_id`, `exam_id`, `user_id`, `date`,`track`,`Percentage`)
  VALUES ("'.$data['question'].'","'.$data['option_1'].'","'.$dat['option_2'].'","'.$data['option_3'].'","'.$data['option_4'].'","'.$data['correct_answer'].'","'.$data['user_answer'].'","'.$data['q_id'].'","'.$exam_id.'","'.$user_id.'","'.date("d-m-Y").'","'.$trackid.'","'.$Percentage.'")';
  $query=mysqli_query($con,$sql);
  }
  //  die;

  if($query)
  {
  // mysqli_set_charset($con,"utf8");
  $con->set_charset("utf8");
  $time=mysqli_fetch_assoc(mysqli_query($con,"select exam_time from exam where id='".$exam_id."'"))['exam_time'];
  $query=mysqli_query($con,"select question,correct_answer,user_answer,option_1,option_2,option_3,option_4,Percentage from result where user_id='$user_id' and exam_id='$exam_id' and track='$trackid' ");
  $count=mysqli_num_rows($query);
  $x=1; $i=0;$right=0;
  while($row=mysqli_fetch_assoc($query))
  {
  //   if($row['correct_answer']!='')
  //   {
  //       if($row['correct_answer']=='A')
  //       {
  //           $row['correct_answer']=$row['option_1'];
  //       }
  //       if($row['correct_answer']=='B')
  //       {
  //           $row['correct_answer']=$row['option_2'];
  //       }
  //       if($row['correct_answer']=='C')
  //       {
  //           $row['correct_answer']=$row['option_3'];
  //       }
  //       if($row['correct_answer']=='D')
  //       {
  //           $row['correct_answer']=$row['option_4'];
  //       }
  //       if($row['correct_answer']==$row['user_answer'])
  //       {
  //           $i++;
  //           $right=$i;
  //       }
  //   }
  if($row['user_answer']!='')
  {
  if($row['user_answer']==$row['option_1'])
  {
  $row['user_answer']='A';
  }
  if($row['user_answer']==$row['option_2'])
  {
  $row['user_answer']='B';
  }
  if($row['user_answer']==$row['option_3'])
  {
  $row['user_answer']='C';
  }
  if($row['user_answer']==$row['option_4'])
  {
  $row['user_answer']='D';
  }
  if($row['user_answer']==$row['correct_answer'])
  {
  $i++;
  $right=$i;
  }
  }
  $row1['question'] =$row['question'];
  $row1['user_answer'] =$row['user_answer'];
  $row1['correct_answer'] =$row['correct_answer'];
  $row1['option_1']=$row['option_1'];
  $row1['option_2']=$row['option_2'];
  $row1['option_3']=$row['option_3'];
  $row1['option_4']=$row['option_4'];


  $row2['question']="$x";
  // $row2['time']=$time;
  if($row['user_answer']===$row['correct_answer']){

  $row2['right']="1";
  }else{
  $row2['right']="0";
  }
  $output2[]=$row2;
  $output[]=$row1;

  $x++; }






  $reper=intVal(($right*100)/$count);

  if($reper<75 && 60<=$reper)
  {
  $text="Average Student";
  $img='http://padhakuji.com/images/smily/smily.png';
  }
  elseif($reper<60 && 40<=$reper)
  {
  $text="Good You Have To Work More Hard";
  $img='http://padhakuji.com/images/smily/smily.png';
  }
  elseif($reper<40  && 33<=$reper)
  {
  $text="You Have To Practive More";
  $img='http://padhakuji.com/images/smily/smily.png';
  }
  elseif($reper<33)
  {
  $text="Failed";
  $img='http://padhakuji.com/images/smily/sad.png';
  }
  else
  {
  $text="Congratulation";
  $img='http://padhakuji.com/images/smily/smily.png';
  }

  if($reper<=0)
  {

  $reper = 0;
  }
  echo json_encode(array("status"=>"1","Response"=>$output,"Question"=>$output2,"total"=>count($output),"right"=>$right,"image"=>$img,"time"=>$time,"percentage"=>$reper.'%','Text'=>$text));

  }
  else
  {
  echo json_encode(array("status"=>"1","Response"=>"Data Not Inserted"));
  }

 */
?>