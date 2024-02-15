<?php


include("includes/header.php");

require("includes/function.php");
require("language/language.php");


$paper_id = $_GET['id'];


if (isset($_POST['submit'])) {
    $category_id = $_POST['category_id'];
    $sub_categories_id = $_POST['sub_categories_id'];
    $lesson_plan_id = $_POST['lesson_plan_id'];
    $lesson_plan_content_id = $_POST['lesson_plan_content_id'];
    $status = $_POST['status'];
    $title = $_POST['title'];

    $qry = mysqli_query($mysqli, "UPDATE one_minute_paper SET category_id='$category_id', sub_categories_id='$sub_categories_id', lesson_plan_id='$lesson_plan_id', lesson_plan_content_id='$lesson_plan_content_id', status='$status',title='$title' WHERE id='$paper_id'");


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
        header("Location: one_minute.php");
        exit;
        
    } else {
        $_SESSION['error_msg'] = "Failed to add Lesson Plan";
        header("Location: one_minute.php");
        exit;
    }
}




$event_sql = "SELECT * FROM one_minute_paper WHERE id = '$paper_id'";
$event_result = mysqli_query($mysqli, $event_sql);
$paper_data = mysqli_fetch_assoc($event_result);


function getCategoryName($mysqli, $category_id) {
    $category_query = mysqli_query($mysqli, "SELECT * FROM `tbl_category` WHERE cid = '$category_id'");
    $category_row = mysqli_fetch_assoc($category_query);

    return isset($category_row['category_name']) ? $category_row['category_name'] : $category_id;
}

function getSubCategoryName($mysqli, $subCategory_id) {
    $subcategory_query = mysqli_query($mysqli, "SELECT * FROM `sub_categories` WHERE id = '$subCategory_id'");
    $subcategory_row = mysqli_fetch_assoc($subcategory_query);

    return isset($subcategory_row['name']) ? $subcategory_row['name'] : '';
}

function getLessonPlanTitle($mysqli, $lesson_plan_id) {
    $lesson_plan_query = mysqli_query($mysqli, "SELECT topics FROM `lesson_plan` WHERE id = '$lesson_plan_id'");
    $lesson_plan_row = mysqli_fetch_assoc($lesson_plan_query);

    return isset($lesson_plan_row['topics']) ? $lesson_plan_row['topics'] : '';
}

function getLessonPlanContentTitle($mysqli, $lesson_plan_content_id) {
    $lesson_plan_content_query = mysqli_query($mysqli, "SELECT slo_content FROM `lesson_plan_content` WHERE id = '$lesson_plan_content_id'");
    $lesson_plan_content_row = mysqli_fetch_assoc($lesson_plan_content_query);

    return isset($lesson_plan_content_row['slo_content']) ? $lesson_plan_content_row['slo_content'] : '';
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
                    <div class="page_title">Edit Paper</div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <div class="add_btn_primary"> <a href="one_minute.php">All Paper</a> </div>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 " >
                            <div>
                                <label>Title</label>
                                <input class="form-control" name="title" value="<?php echo isset($paper_data['title'])?$paper_data['title']:''?>">
                                 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Category</label>
                                       

                                <select class="form-control" onchange="getCategory()" id="category" name="category_id">
                                 
                                        <option value="" ><?php echo getCategoryName($mysqli, $paper_data['category_id']); ?></option>
                                   
                                </select>
                            </div>

                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Sub Category</label>
                                <select class="form-control" id="subCategory" onchange="getSubCategory()" name="sub_categories_id">
                                     <option value="" ><?php echo getSubCategoryName($mysqli, $paper_data['sub_categories_id']); ?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>Lesson Plan</label>
                                <select class="form-control" id="lesson_plan" onchange="lessonPlan()" name="lesson_plan_id">
                                   <option value="" > <?php echo getLessonPlanTitle($mysqli, $paper_data['lesson_plan_id']); ?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label>SLO Content</label>
                                <select class="form-control" id="slo_content"  name="lesson_plan_content_id">
                                    <option value="" ><?php echo getLessonPlanContentTitle($mysqli, $paper_data['lesson_plan_content_id']); ?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 martin_top">
                            <div>
                                <label> Status </label>
                                <select class="form-control" id="status"  name="status">
                                    <?php if($paper_data['status']==1){?>
                                    <option value="1" > Active </option>
                                    <?php }else{?>
                                    <option value="0" > Block </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-12 col-md-12 col-sm-12  martin_top" >
                            <!--<a  class="add_fields btn btn-info pull-right" style="margin-bottom: 0px;"> Add More </a>-->
                            <div >
                                <div class="row wrapper" >
                                    <?php
                                    $ques_sql = "SELECT * FROM one_minute_paper_question WHERE one_minute_paper_id = '$paper_id'";
                                    $event_result = mysqli_query($mysqli, $ques_sql);
                                    $i=1;
                                    while ($ques_data = mysqli_fetch_assoc($event_result)) {
                                    ?>
                                    <div class="col-sm-12 " style="margin-top:20px">
                                        
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Question <span class="badge badge-info"><?php echo $i++; ?></span></label>
                                                <textarea class="form-control" name=""><?php echo $ques_data['question']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>

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


<?php 
$category_id = $paper_data['category_id'];
$sub_categories_id = $paper_data['sub_categories_id'];
$lesson_plan_id = $paper_data['lesson_plan_id'];
?>

<script>
    // document.addEventListener("DOMContentLoaded", function () {
    //     document.querySelector("#category").addEventListener("change", getCategory);
    //     document.querySelector("#subCategory").addEventListener("change", getSubCategory);
    //     document.querySelector("#lesson_plan").addEventListener("change", lessonPlan);

    //     getCategory();
    //     getSubCategory(<?php echo $category_id; ?>); 
    //     lessonPlan(<?php echo $sub_categories_id; ?>);
    // });

    // const fetchData = async (url) => {
    //     const response = await fetch(url);
    //     return await response.text();
    // }

    // const getCategory = async () => {
    //     try {
    //         const val = document.querySelector("#category").value;
    //         const url = `getsubcategory.php?id=${val}`;
    //         const data = await fetchData(url);
    //         document.querySelector('#subCategory').innerHTML = data;
    //     } catch (error) {
    //         console.log(`The Error is ${error}`);
    //     }
    // }

    // const getSubCategory = async () => {
    //     try {
    //         const val = document.querySelector("#subCategory").value;
    //         const url = `subCategory.php?id=${val}`;
    //         const data = await fetchData(url);
    //         document.querySelector('#lesson_plan').innerHTML = data;
    //     } catch (error) {
    //         console.log(`The Error is ${error}`);
    //     }
    // }

    // const lessonPlan = async () => {
    //     try {
    //         const val = document.querySelector("#lesson_plan").value;
    //         const url = `getLessonPlans.php?id=${val}`;
    //         const data = await fetchData(url);
    //         document.querySelector('#slo_content').innerHTML = data;
    //     } catch (error) {
    //         console.log(`The Error is ${error}`);
    //     }
    // }
</script>


<script>



    // $(document).ready(function() {
    //     var max_fields = 10;
    //     var wrapper = $(".wrapper");
    //     var add_button = $(".add_fields");
    //     var x = 1;

    //     $(add_button).click(function(e) {
    //         e.preventDefault();
    //         if (x < max_fields) {
    //             x++;
    //             $(wrapper).append(`
    //                 <div class="col-sm-12">
    //                     <a href="javascript:void(0);" class="remove_field btn btn-danger pull-right">X</a>
    //                     <div class="row">
                            
    //                         <div class="col-sm-12">
    //                             <label>Question</label>
    //                             <textarea class="form-control" name="question[]"></textarea>
    //                         </div>
    //                     </div>
    //                 </div>
    //             `);
    //         }
    //     });

    //     $(wrapper).on("click", ".remove_field", function(e) {
    //         e.preventDefault();
    //         $(this).parent('div').remove();
    //         x--;
    //     });
    // });
</script>