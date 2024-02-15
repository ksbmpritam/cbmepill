<?php
include("includes/header_teacher.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

$teacherId = $_SESSION['teacher_id'] ?? 58;


if (isset($_POST['submit'])) {
    
    $category_id = $_POST['category_id'];
    $sub_categories_id = $_POST['sub_categories_id'];
    $lesson_plan_id = $_POST['lesson_plan_id'];
    $lesson_plan_content_id = $_POST['lesson_plan_content_id'];
    
    $sql = "SELECT * FROM `one_minute_paper` WHERE sub_categories_id='$sub_categories_id' AND category_id='$category_id' AND lesson_plan_id='$lesson_plan_id' AND lesson_plan_content_id='$lesson_plan_content_id'";
    $query = mysqli_query($mysqli,$sql);
    
    if (mysqli_num_rows($query) > 1) {
        $_SESSION['error_msg'] = "One minute paper already exists for the selected category and subcategory. Please select other Category and Sub Category";
        
        //header("Location: add_lession_plan.php");
        //exit;
        
    }else{
    
    
        $status = $_POST['status'];
        $title = $_POST['title'];
        
        $data = array(
            'user_id'=>$teacherId,
            'category_id' => $category_id,
            'sub_categories_id' =>  $sub_categories_id,
            'lesson_plan_id' => $lesson_plan_id,
            'lesson_plan_content_id' => $lesson_plan_content_id,
            'status' => $status,
            'title' => $title,
        );
    
        $oneMinute = Insert('one_minute_paper', $data);
        
        if ($oneMinute) {
            for ($i = 0; $i < count($_POST['question']); $i++) {
                $question = $_POST['question'][$i];
            
                $contentData = array(
                    'question' => $question,
                    'one_minute_paper_id' => $oneMinute
                );
    
                Insert('one_minute_paper_question', $contentData);
            }
    
            $_SESSION['msg'] = "Question added successfully";
            header("Location: one_minute_teacher.php");
            exit;
        } else {
            // Handle the case where lesson plan insertion failed
            $_SESSION['error_msg'] = "Failed to add Lesson Plan";
            header("Location: add_one_minute_paper_teacher.php");
            exit;
        }
    }
}

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
                    <div class="page_title">Add One Minute Paper</div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <div class="add_btn_primary"> <a href="one_minute_teacher.php">All Paper</a> </div>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 " >
                            <div>
                                <label>Title</label>
                                <input class="form-control" name="title">
                                 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Category</label>
                                <select class="form-control" onchange="getCategory()" id="category" name="category_id">
                                    <option value="" selected> -- Select Category -- </option>
                                    <?php
                                    $sql2 = "SELECT cid,category_name FROM `tbl_category` ORDER BY category_name";
                                    $query2 = mysqli_query($mysqli, $sql2);
                                    
                                    
                                    while ($row2 = mysqli_fetch_assoc($query2)) {
                                    ?>
                                        <option value="<?= $row2['cid'] ?>"><?= $row2['category_name'] ?></option>
                                     
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Sub Category</label>
                                <select class="form-control" id="subCategory" onchange="getSubCategory()" name="sub_categories_id">
                                    <option value="" selected> -- First Select Category --- </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Lesson Plan</label>
                                <select class="form-control" id="lesson_plan" onchange="lessonPlan()" name="lesson_plan_id">
                                    <option value="" selected> -- First Select Sub Category --- </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>SLO Content</label>
                                <select class="form-control" id="slo_content"  name="lesson_plan_content_id">
                                    <option value="" selected> -- First Select Lesson Plan  --- </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label> Status </label>
                                <select class="form-control" id="status"  name="status">
                                    <option value="1" > Active </option>
                                    <option value="0" > Block </option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-12 col-md-12 col-sm-12  martin_top" >
                            <a  class="add_fields btn btn-info pull-right" style="margin-bottom: 0px;">Add More </a>
                            <div>
                                <div class="row wrapper">
                                    <div class="col-sm-12">
                                        <label>Question</label>
                                        <textarea class="form-control" name="question[]"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                            <div>
                                <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
<script type="text/javascript" src="assets/js/pekeUpload.js"></script>

<script>

const getCategory = async () => {
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

const getSubCategory = async () => {
    try {
        let val = document.querySelector("#subCategory").value;
        let url = `subCategory.php?id=${val}`;
        let response = await fetch(url);
        let data = await response.text();
        document.querySelector('#lesson_plan').innerHTML = data;
    } catch (error) {
        console.log(`The Error is ${error}`);
    }
}

const lessonPlan = async () => {
    try {
        let val = document.querySelector("#lesson_plan").value;
        let url = `getLessonPlans.php?id=${val}`;
        let response = await fetch(url);
        let data = await response.text();
        document.querySelector('#slo_content').innerHTML = data;
    } catch (error) {
        console.log(`The Error is ${error}`);
    }
}

// window.addEventListener('DOMContentLoaded', (event) => {
//     getSubCategory();
// });



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
                    <div class="col-sm-12">
                        <a href="javascript:void(0);" class="remove_field btn btn-danger pull-right">X</a>
                        <div class="row">
                            
                            <div class="col-sm-12">
                                <label>Question</label>
                                <textarea class="form-control" name="question[]"></textarea>
                            </div>
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