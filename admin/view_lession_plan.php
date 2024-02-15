<?php
include("includes/header_teacher.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

$lesson_id = $_GET['id'];

if (isset($_POST['submit'])) {
    $topics = $_POST['topics'];
    $class = $_POST['class'];
    $duration = $_POST['duration'];
    $subject = $_POST['subject'];
    $date = $_POST['date'];

    $qry = mysqli_query($mysqli, "UPDATE lesson_plan SET topics='$topics', class='$class', duration='$duration', subject='$subject', date='$date' WHERE id='$lesson_id'");


    if ($lesson_id) {
        $deleteQry = mysqli_query($mysqli, "DELETE FROM lesson_plan_content WHERE lesson_plan_id='$lesson_id'");
        
        for ($i = 0; $i < count($_POST['slo_content']); $i++) {
            $sloContent = $_POST['slo_content'][$i];
            $method = $_POST['method'][$i];
            $timeAllotted = $_POST['time_allotted'][$i];
            $resourceProvided = $_POST['resource_provided'][$i];

            $contentData = array(
                'lesson_plan_id' => $lesson_id,
                'slo_content' => $sloContent,
                'method' => $method,
                'time_allotted' => $timeAllotted,
                'resource_provided' => $resourceProvided,
            );

            Insert('lesson_plan_content', $contentData);
        }

        $_SESSION['msg'] = "Lesson Plan and Content added successfully";
        header("Location: all_lession_plan.php");
        exit;
    } else {
        $_SESSION['error_msg'] = "Failed to add Lesson Plan";
        header("Location: view_lession_plan.php");
        exit;
    }



    $_SESSION['msg'] = "Lesson Plan Updated successfully";
    header("Location: all_lession_plan.php");
    exit;
}


$event_sql = "SELECT * FROM lesson_plan WHERE id = '$lesson_id'";
$event_result = mysqli_query($mysqli, $event_sql);
$data = mysqli_fetch_assoc($event_result);



$event_sql = "SELECT * FROM lesson_plan_title where id = 1";

$event_result = mysqli_query($mysqli, $event_sql);

$data_title = mysqli_fetch_assoc($event_result);
?>

<link rel="stylesheet" href="assets/css/custom.css">

<style>
    .top_margin {
        margin: 15px 0 !important;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">View Lesson Plan</div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <div class="add_btn_primary"> <a href="all_lession_plan.php">All Lesson Plan</a> </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row mrg-top">
                <div class="col-md-12">
                    <div class="col-md-12 col-sm-12">
                        <?php if (isset($_SESSION['msg'])) { ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <?php echo $_SESSION['msg']; ?>
                            </div>
                            <?php unset($_SESSION['msg']);
                        } ?>
                    </div>
                </div>
            </div>

            <div class="card-body mrg_bottom">
                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <div class="row px-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Topics</label>
                                <input type="text" class="form-control" name="topics" value="<?php echo $data['topics']; ?>" id="topics" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Class</label>
                                <input type="text" class="form-control" name="class" value="<?php echo $data['class']; ?>" id="class" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Duration</label>
                                <input type="text" class="form-control" name="duration" value="<?php echo $data['duration']; ?>" id="duration" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Subject</label>
                                <input type="text" class="form-control" name="subject" value="<?php echo $data['subject']; ?>" id="subject" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Date</label>
                                <input type="date" class="form-control" name="date" value="<?php echo $data['date']; ?>" id="date" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Status</label>
                                <select class="form-control"  name="status">
                                    
                                    <option value="1" <?php if($data['status']==1){ ?>selected<?php }?>>Active</option>
                                    
                                    <option value="0" <?php if($data['status']==0){ ?>selected<?php }?>>Block</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <!--<a class="add_fields btn btn-info pull-right disabled">Add More</a>-->
                            <div class="row wrapper">
                                <?php
                                $sloContents = getSloContents($lesson_id);
                                
                                foreach ($sloContents as $index => $sloContent) {
                                ?>
                                
                                    <div class="col-sm-12">
                                        <a href="javascript:void(0);" class="remove_field btn btn-danger pull-right disabled">Remove</a>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label><?=$data_title['slo_content_title']; ?></label>
                                                <input type="text" class="form-control" name="slo_content[]" value="<?php echo $sloContent['slo_content']; ?>" required/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label><?=$data_title['method_title']; ?></label>
                                                <input type="text" class="form-control" name="method[]" value="<?php echo $sloContent['method']; ?>" required/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label><?=$data_title['time_allotted_title']; ?></label>
                                                <input type="time" class="form-control" name="time_allotted[]" value="<?php echo $sloContent['time_allotted']; ?>" required/>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><?=$data_title['resource_provided_title']; ?></label>
                                                <textarea class="form-control" name="resource_provided[]"><?php echo $sloContent['resource_provided']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!--<div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">-->
                        <!--    <div>-->
                        <!--        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
<script type="text/javascript" src="assets/js/pekeUpload.js"></script>

<script>
    $(document).ready(function() {
        $("#file").pekeUpload({
            onSubmit: true,
            limit: 4,
            bootstrap: true,
            dragMode: true
        });
    });

    $(document).ready(function() {
        var max_fields = 10;
        var wrapper = $(".wrapper");
        var add_button = $(".add_fields");
        var x = 1;

        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append(`
                    <div>
                        <a href="javascript:void(0);" class="remove_field btn btn-danger pull-right">Remove</a>
                        <div class="col-sm-12">
                            <label><?=$data_title['slo_content_title']; ?></label>
                            <input type="text" class="form-control" name="slo_content[]" required/>
                        </div>
                        <div class="col-sm-6">
                            <label><?=$data_title['method_title']; ?></label>
                            <input type="text" class="form-control" name="method[]" required/>
                        </div>
                        <div class="col-sm-6">
                            <label><?=$data_title['time_allotted_title']; ?></label>
                            <input type="time" class="form-control" name="time_allotted[]" required/>
                        </div>
                        <div class="col-sm-12">
                            <label><?=$data_title['resource_provided_title']; ?></label>
                            <textarea class="form-control" name="resource_provided[]"></textarea>
                        </div>
                    </div>
                `);
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });
    });
</script>
