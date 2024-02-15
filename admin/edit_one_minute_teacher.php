<?php
include("includes/header_teacher.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

$paper_id = $_GET['id'];
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
        // header("Location: add_lession_plan.php");
        // exit;
    }else{
        
        $status = $_POST['status'];
        $title = $_POST['title'];
    
        $qry = mysqli_query($mysqli, "UPDATE one_minute_paper SET user_id='$teacherId', category_id='$category_id', sub_categories_id='$sub_categories_id', lesson_plan_id='$lesson_plan_id', lesson_plan_content_id='$lesson_plan_content_id', status='$status',title='$title' WHERE id='$paper_id'");
    
    
        if ($paper_id) {
    
          for ($i = 0; $i < count($_POST['question']); $i++) {
                $question = $_POST['question'][$i];
            
                $contentData = array(
                    'question' => $question,
                    'one_minute_paper_id' => $paper_id
                );
    
                Insert('one_minute_paper_question', $contentData);
            }
    
            $_SESSION['msg'] = "Lesson Plan and Content added successfully";
            header("Location: one_minute_teacher.php");
            exit;
            
        } else {
            $_SESSION['error_msg'] = "Failed to add Lesson Plan";
            header("Location: one_minute_teacher.php");
            exit;
        }
    }
}





$event_sql = "SELECT * FROM one_minute_paper WHERE id = '$paper_id'";
$event_result = mysqli_query($mysqli, $event_sql);
$paper_data = mysqli_fetch_assoc($event_result);




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
                    <div class="page_title">Edit Paper</div>
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
                                <input class="form-control" name="title" value="<?php echo isset($paper_data['title'])?$paper_data['title']:''?>">
                                 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Category</label>
                                <select class="form-control" onchange="getCategory()" id="category" name="category_id" required>
                                    <?php
                                    $sql2 = "SELECT cid,category_name FROM `tbl_category` ORDER BY category_name";
                                    $query2 = mysqli_query($mysqli, $sql2);
                                    
                                    
                                    while ($row2 = mysqli_fetch_assoc($query2)) {
                                        if($row2['cid']==$row2['category_id']){
                                    ?>
                                        <option value="<?= $row2['cid'] ?>" selected><?= $row2['category_name'] ?></option>
                                     
                                    <?php }else{ ?>
                                        <option value="<?= $row2['cid'] ?>"><?= $row2['category_name'] ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Sub Category</label>
                                <select class="form-control" id="subCategory" onchange="getSubCategory()" name="sub_categories_id" required>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Lesson Plan</label>
                                <select class="form-control" id="lesson_plan" onchange="lessonPlan()" name="lesson_plan_id" required>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>SLO Content</label>
                                <select class="form-control" id="slo_content"  name="lesson_plan_content_id" required>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label> Status </label>
                                <select class="form-control" id="status"  name="status">
                                    
                                        <option value="1" <?php if($paper_data['status']==1){?>selected<?php }?>> Active </option>
                                        <option value="0" <?php if($paper_data['status']==0){?>selected<?php }?>> Block </option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-12 col-md-12 col-sm-12" >
                            
                            <div >
                                <div class="row" >
                                    <?php
                                    $ques_sql = "SELECT * FROM one_minute_paper_question WHERE one_minute_paper_id = '$paper_id'";
                                    $event_result = mysqli_query($mysqli, $ques_sql);
                                
                                    while ($ques_data = mysqli_fetch_assoc($event_result)) {
                                    ?>
                                    <div class="col-sm-12 ">
                                        <a href="javascript:void(0);" class="btn btn-danger pull-right" onclick="deletePaper(<?php echo $ques_data['id']; ?>)">X</a>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Question</label>
                                                <textarea class="form-control" name="" readonly><?php echo $ques_data['question']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12  martin_top" >
                            <a  class="add_fields btn btn-info pull-right" >Add More </a>
                            <div >
                                <div class="row wrapper" >
                                  
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


<?php 
$category_id = $paper_data['category_id'];
$sub_categories_id = $paper_data['sub_categories_id'];
$lesson_plan_id = $paper_data['lesson_plan_id'];
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#category").addEventListener("change", getCategory);
        document.querySelector("#subCategory").addEventListener("change", getSubCategory);
        document.querySelector("#lesson_plan").addEventListener("change", lessonPlan);

        getCategory();
        getSubCategory(<?php echo $category_id; ?>); 
        lessonPlan(<?php echo $sub_categories_id; ?>);
    });

    const fetchData = async (url) => {
        const response = await fetch(url);
        return await response.text();
    }

    const getCategory = async () => {
        try {
            const val = document.querySelector("#category").value;
            const url = `getsubcategory.php?id=${val}`;
            const data = await fetchData(url);
            document.querySelector('#subCategory').innerHTML = data;
        } catch (error) {
            console.log(`The Error is ${error}`);
        }
    }

    const getSubCategory = async () => {
        try {
            const val = document.querySelector("#subCategory").value;
            const url = `subCategory.php?id=${val}`;
            const data = await fetchData(url);
            document.querySelector('#lesson_plan').innerHTML = data;
        } catch (error) {
            console.log(`The Error is ${error}`);
        }
    }

    const lessonPlan = async () => {
        try {
            const val = document.querySelector("#lesson_plan").value;
            const url = `getLessonPlans.php?id=${val}`;
            const data = await fetchData(url);
            document.querySelector('#slo_content').innerHTML = data;
        } catch (error) {
            console.log(`The Error is ${error}`);
        }
    }
    
    const deletePaper = async (paperId) => {
        if (confirm("Are you sure you want to delete this Paper?")) {
            try {
                const response = await new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_paper.php',
                        data: { paperId: paperId },
                        success: resolve,
                        error: reject
                    });
                });
    
                if (response) {
                    location.reload();
                } else {
                    alert('Error deleting content: ' + response);
                }
            } catch (error) {
                console.error('Error deleting content:', error);
                alert('Error deleting content: ' + error.statusText);
            }
        }
    };

    
</script>


<script>



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