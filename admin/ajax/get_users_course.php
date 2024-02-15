<?php
include("../includes/connection.php");
global $mysqli;

$id = base64_decode($_REQUEST['id']);
$sqli = "SELECT * from user where user_id='$id'";
$data = mysqli_query($mysqli, $sqli);
$user = mysqli_fetch_assoc($data);
//print_r($user);	



$cat_qry = "SELECT * FROM tbl_category ORDER BY category_name";
$cat_result = mysqli_query($mysqli, $cat_qry);
?>

<div class="row">
    <div class="col-md-1"> 
    </div>
    <div class="col-md-6"> 
        User Name  : <?php echo $user['name']; ?>
        <BR/>Moblie : <?php echo $user['mobile']; ?>
        <BR/>Email  : <?php echo $user['email']; ?></h2>
    </div>

    <div class="col-md-5"> 

        Course_id: <?php echo $user['csid']; //echo get_user_old_data($userid , 'csid');   ?>  
        <BR/> Subjects_id: <?php echo $user['subid']; // get_user_old_data($userid , 'subid');   ?>  

    </div>     
</div>
<hr/>
<form method="post">
    <input type="hidden" name="update_user_id" value="<?php echo $user['user_id']; ?>" >
    <div class="row">
        <div class="col-md-12"> 
            <?php
            $cacba_course_id_up = $cat_row['cid']; //;
            $selected_course_ids_array = explode(',', $user['csid']);

            $selected_data = "";
            while ($cat_row = mysqli_fetch_array($cat_result)) {
                $selected = "";
                if (in_array($cat_row['cid'], $selected_course_ids_array)) {
                    $selected = "checked='checked' ";
                }
                ?>
                <div class="row">
                    <div class="col-md-4"> 
                        Course : <p> 
                            <input type="checkbox" name="course_id[]" value="<?php echo $cat_row['cid']; ?>" <?= $selected; ?> >   <?php echo ' ' . $cat_row['category_name']; ?>	          							 
                        </p>
                    </div>
                    <div class="col-md-8"> 
                        Subjects : 
                        <ol>
                            <?php
                            $html = "";
                            $cacba_course_id_up = $cat_row['cid']; //;
                            $selected_cacba_subjects_ids_array = explode(',', $user['subid']);
                            $query = "select * from subject where course_id='$cacba_course_id_up'";
                            $result_cc = mysqli_query($mysqli, $query);

                            $d_cc = mysqli_fetch_all($result_cc, MYSQLI_ASSOC);
                            foreach ($d_cc as $record) {

                                $selected = "";
                                if (in_array($record['id'], $selected_cacba_subjects_ids_array)) {
                                    $selected = "checked='checked' ";
                                }

                                $html .= '<li> <input type="checkbox" name="subjects_id[]" value=' . $record['id'] . '  ' . $selected . '>&nbsp;' . $record['subject_name'] . '</li>';
                            }
                            echo $html;
                            ?>
                        </ol>
                    </div>     
                </div>
                <hr/>
            <?php } ?> 
        </div>
    </div>
    <input type="submit" name="update_course" value="Update Course subject">
</form>