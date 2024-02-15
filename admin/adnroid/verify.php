<?php

include("db.php");

if (isset($_REQUEST['subject_id']) && isset($_REQUEST['user_id'])) {
    if ($_POST['user_id'] == '') {
        echo json_encode(array("status" => "0", "Response" => "Blank User Id"));
    } elseif ($_POST['subject_id'] == '') {
        echo json_encode(array("status" => "0", "Response" => "Blank Subject Id"));
    } else {

        // $sql_coupons=mysqli_query($con,"SELECT * FROM `coupons_master` WHERE ");
        // $coupon_data=mysqli_fetch_assoc($sql_coupons);

        $user_id = $_POST['user_id'];
        $subject_id = $_POST['subject_id'];

        // to findout the course_id from the subject table
        $second = mysqli_fetch_assoc(mysqli_query($con, "select course_id from subject where id='$subject_id'"))['course_id'];

        // if user access
        $sql = mysqli_query($con, "select * from user where user_id='$user_id'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);

            # IF COURSE FOUND AS BLANNK IN USER TABLE

            $allamount = '0';
            $allmcqamount = '0';

//            $query = mysqli_query($con, "select * from subject where course_id='" . $second . "' AND id='$subject_id'");
//            $query = mysqli_query($con, "select * from subject where course_id='" . $second . "'");
            $query = mysqli_query($con, "select * from tbl_category where cid='" . $second . "'");
            if (mysqli_num_rows($query) > 0) {
                $data = array();
                $video = 0;
                $pdf = 0;
                $mcq = 0;
                while ($row = mysqli_fetch_assoc($query)) {
                    $amount = explode(',', $row['amount']);

                    $data = $row['amount'];
                    //  print_r($amount);
                    //  exit;
//                    if ($amount[0] != null && $amount[0] != "") {
//                        $data['video'] += $amount[0];
//                    } else {
//                        $data['video'] += 0;
//                    }
//
//                    if ($amount[1] != null && $amount[1] != "") {
//                        $data['pdf'] += $amount[1];
//                    } else {
//                        $data['pdf'] += 0;
//                    }
//                    if ($amount[2] != null && $amount[2] != "") {
//                        $data['mcq'] += $amount[2];
//                    } else {
//                        $data['mcq'] += 0;
//                    }



                    //  $amr=0;
                    //  foreach($amount as $am)
                    //  {
                    //     $allamount+=$am;
                    //     if($amr==0)
                    //     {
                    //         $video+=$am;
                    //         $data['video']=$video;
                    //     }
                    //     if($amr==1)
                    //     {
                    //         $pdf+=$am;
                    //         $data['pdf']=$pdf;
                    //     }
                    //     if($amr==2)
                    //     {
                    //         $mcq+=$am;
                    //         $data['mcq']=$mcq;
                    //     }
                    //     $amr++;
                    //  }
                    //  $i=0;
                    //  foreach($amount as $am)
                    //  {
                    //     if($i==2)
                    //     {
                    //      $allmcqamount+=$am; 
                    //     }
                    //     $i++;
                    //  }
                }
            }

            echo json_encode(array("status" => "1", "Response" => "1", "amount" => $data));
            die;
        }
    }
} else {
    echo json_encode(array("status" => "0", "response" => "Something Wrong"));
}
?>
		