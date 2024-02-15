<?php
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");


$teacherId = $_SESSION['teacher_id'] ?? 58;

if (isset($_POST['submit'])) {
    
    $category = $_POST['category']; 
    $subcategory = $_POST['subcategory'];
    

    $sql = "SELECT * FROM `lesson_plan` WHERE sub_categories_id='$subcategory' AND category_id='$category'";
    $query = mysqli_query($mysqli,$sql);
    
    // Check if lesson plan already exists
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['error_msg'] = "Lesson Plan already exists for the selected category and subcategory. Please select other Category and Sub Category";
        // header("Location: add_lession_plan.php");
        // exit;
    }else{
    
        
        $topics = $_POST['topics'];
        $class = $_POST['class'];
        $duration = $_POST['duration'];
        $subject = $_POST['subject'];
        $date = $_POST['date'];
        $category = $_POST['category'];
        $subcategory = $_POST['subcategory'];
        $status = $_POST['status'];
    
        $data = array(
            'user_id'=>$teacherId,
            'category_id' => $category,
            'sub_categories_id' => $subcategory,
            'topics' =>  $topics,
            'class' => $class,
            'duration' => $duration,
            'subject' => $subject,
            'date' => $date,
            'status' => $status,
            
        );
    
        $lessonPlanId = InsertLesson('lesson_plan', $data);
        
        if ($lessonPlanId) {
            for ($i = 0; $i < count($_POST['slo_content']); $i++) {
                $sloContent = $_POST['slo_content'][$i];
                $method = $_POST['method'][$i];
                $timeAllotted = $_POST['time_allotted'][$i];
                $resourceProvided = $_POST['resource_provided'][$i];
    
                $contentData = array(
                    'lesson_plan_id' => $lessonPlanId,
                    'user_id'=>$teacherId,
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
            // Handle the case where lesson plan insertion failed
            $_SESSION['error_msg'] = "Failed to add Lesson Plan";
            header("Location: add_lession_plan.php");
            exit;
        }
    }
}



$event_sql = "SELECT * FROM lesson_plan_title where id = 1";
$event_result = mysqli_query($mysqli, $event_sql);
$data_title = mysqli_fetch_assoc($event_result);


?>
<link rel="stylesheet" href="assets/css/custom.css">

<style>
    .top_margin{
        margin: 15px 0!important;
    }
</style>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Add Lession Plan</div>

                </div>
                <div class="col-md-7 col-xs-12">
                  <div class="search_list">
                    
                      
                    <div class="add_btn_primary"> <a href="all_lession_plan.php">All Lession Plan</a> </div>
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

                                <?php echo $_SESSION['msg']; ?></a> </div>

                        <?php unset($_SESSION['msg']);
                            }
                        ?> 
                            
                        <?php if ($_SESSION['error_msg']) { ?> 

                            <div class="alert alert-danger alert-dismissible" role="alert"> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                <?php echo $_SESSION['error_msg']; ?></a> </div>

                            <?php unset($_SESSION['error_msg']);
                                }
                            ?> 

                    </div>

                </div>

            </div>

            <div class="card-body mrg_bottom"> 

                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                            
                            
                            <div class="row px-2">
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Category</label>
                                        <select class="form-control" onchange="getSubCategory()" id="category" name="category">
                                            <?php
                                            $sql = "SELECT cid,category_name FROM `tbl_category` ORDER BY category_name";
                                            $query = mysqli_query($mysqli, $sql);
                                            while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                                <option value="<?= $row['cid'] ?>"><?= $row['category_name'] ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Sub Category</label>
                                        <select class="form-control" id="subCategory" name="subcategory">
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Topics</label>
                                        <input type="text" class="form-control" name="topics" id="topics" required/>

                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Class</label>
                                        <input type="text" class="form-control" name="class" id="class" required/>

                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Duration</label>
                                        <input type="number" class="form-control" name="duration" id="duration" required/>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" id="subject" required/>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="date" id="date" required/>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Status</label>
                                        <select class="form-control"  name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <a  class="add_fields btn btn-info pull-right">Add More </a>
                                    <div class="row wrapper">
                                      <div class="col-sm-12">
                                            <label><? echo $data_title['slo_content_title']; ?></label>
                                            <input type="text" class="form-control" name="slo_content[]" required/>
                                      </div>
                                      
                                      <div class="col-sm-6">
                                            <label><? echo $data_title['method_title']; ?></label>
                                            <input type="text" class="form-control" name="method[]" required/>
                                      </div>
                                      <div class="col-sm-6">
                                            <label><? echo $data_title['time_allotted_title']; ?></label>
                                            <input type="time" class="form-control" name="time_allotted[]"  required/>
                                      </div>
                                      <div class="col-sm-12">
                                            <label><? echo $data_title['resource_provided_title']; ?></label>
                                            <textarea class="form-control" name="resource_provided[]" ></textarea>
                                      </div>

                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                                    <div>
                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                                    
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<?php include ("includes/footer.php"); ?>       
<script type="text/javascript" src="assets/js/pekeUpload.js"></script>
<script>
const getSubCategory = async () => {
    try {
        let val = document.querySelector("#category").value;
        let url = `getsubcategory.php?id=${val}`;
        let response = await fetch(url);
        let data = await response.text();
        document.querySelector('#subCategory').innerHTML = data;
    } catch (error) {
        console.log(`The Error is ${error}`);
    }
}

window.addEventListener('DOMContentLoaded', (event) => {
    getSubCategory();
});


$(document).ready(function() {


    $("#file").pekeUpload(
        {
            onSubmit:true,
            limit:4,
            bootstrap:true,
            dragMode:true

        }
    );
    
});


 $(document).ready(function () {
    var max_fields = 10;
    var wrapper = $(".wrapper");
    var add_button = $(".add_fields");
    var x = 1;

    $(add_button).click(function (e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append(`
                <div>
                    <a href="javascript:void(0);" class="remove_field btn btn-danger pull-right">Remove</a>
                    <div class="col-sm-12">
                        <label><? echo $data_title['slo_content_title']; ?></label>
                        <input type="text" class="form-control" name="slo_content[]" required/>
                    </div>
                    <div class="col-sm-6">
                        <label><? echo $data_title['method_title']; ?></label>
                        <input type="text" class="form-control" name="method[]" required/>
                    </div>
                    <div class="col-sm-6">
                        <label><? echo $data_title['time_allotted_title']; ?></label>
                        <input type="time" class="form-control" name="time_allotted[]" required/>
                    </div>
                    <div class="col-sm-12">
                        <label><? echo $data_title['resource_provided_title']; ?></label>
                        <textarea class="form-control" name="resource_provided[]" id="resource_provided"></textarea>
                    </div>
                    
                </div>
            `);
        }
    });

    $(wrapper).on("click", ".remove_field", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
});
</script>