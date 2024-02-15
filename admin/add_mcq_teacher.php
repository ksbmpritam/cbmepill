<?php
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");


if (isset($_POST['submit'])) {
    //Main Image
    // $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    $write_option = filter($_POST['write_option']);
    $title_heading = str_replace("'","\'",$_POST['title_heading']);
    $mcq_timer = filter($_POST['mcq_timer']);
    $why_ans_mcq = filter($_POST['why_ans_mcq']);
    
    
      $category = array();
     $sql_cat = "SELECT category_id From `sub_categories` where id = $subcategory ";
    
     $query_cat = mysqli_query($mysqli,$sql_cat);
     while ($row_query_cat = mysqli_fetch_assoc($query_cat)){
        $category['c_id'] =  $row_query_cat['category_id'];
     };
    
    
    
    if(isset($_FILES['title_image']['name']) && !empty($_FILES['title_image']['name'])){
        $title_image = $_FILES['title_image'];
        
        $title_image_name = time().".png";
        move_uploaded_file($title_image['tmp_name'],"mcq_images/".$title_image_name);
    }else{
        $title_image_name = "";
    }
    
    
    $photo_new_name_array = [];
    
    if(isset($_FILES['options'])){
        $photos = $_FILES['options'];
        
        $photo_name = $photos['name'];
        $photo_type = $photos['type'];
        $photo_tmp_name = $photos['tmp_name'];
        $photo_error = $photos['error'];
        $photo_size = $photos['size'];
        
        $time = time()+1;
        $photo_dynamic_name = $time.".png";
        
        $count = count($photo_name);
        
        for($i=0;$i<$count;$i++){
            $photo_dynamic_name = $time.".png";
            array_push($photo_new_name_array,$photo_dynamic_name);
            move_uploaded_file($photo_tmp_name[$i],"mcq_images/".$photo_dynamic_name);
            $time++;
        }
    }else{
        $photo_new_name_array = $_POST['options'];
    }
    
    
    
    $data = array(
        'c_id' =>  $category['c_id'],
        'sc_id' => $subcategory,
        'title_text' => $title_heading,
        'title_img' => $title_image_name,
        'options' => implode("|",$photo_new_name_array),
        'right_option' => $write_option,
        'timer' => $mcq_timer,
        'why_ans_mcq' => $why_ans_mcq,
        );
    Insert('mcq', $data);
    $_SESSION['msg'] = "Mcq Added Success";
    header("Location:all_mcq_teacher.php");
    exit;
}
?>
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

                    <div class="page_title">Add MCQ</div>

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

                    </div>

                </div>

            </div>

            <div class="card-body mrg_bottom"> 

                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                            
                            
                            <div class="row px-2">
                                
                          
                                
                                       <div class="col-lg-6 col-md-6 col-sm-12">
                                           <div>
                                <label>Sub Category</label>
                                <select class="form-control" name="subcategory" required>
                                      <option value="">Select</option>
                                    <?php 
                                     $sql_sub_cat_id = "SELECT id, teacher_id ,name,category_id
                                        FROM sub_categories
                                        WHERE FIND_IN_SET('$userValue', teacher_id);";
                                    $query_sub_cat = mysqli_query($mysqli, $sql_sub_cat_id);
                                  
                                    while ($row_sub_cat_id = mysqli_fetch_assoc($query_sub_cat)) {
                                        ?>
                                        <option value="<?= $row_sub_cat_id['id'] ?>"><?= $row_sub_cat_id['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                </div>
                        </div>
                                
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title_heading">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Title Image</label>
                                        <input type="file" onfocus="this.type='file'" class="form-control" name="title_image">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Mcq Timer (In seconds..)</label>
                                        <input type="number" min="5" value="30" class="form-control" name="mcq_timer">
                                    </div>
                                </div>
                                
                                 <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Why Ans is wright</label>
                                        <input type="text"  class="form-control" name="why_ans_mcq" required  >
                                    </div>
                                </div>
                                
                                        
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <label>Option Type</label>
                                    <select class="form-control" onchange="change_type(this.value)">
                                        <option value="1">Text</option>
                                        <option value="2">Image</option>
                                    </select>
                                </div>
                                
                                    
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="options[]" class="form-control options"  accept="image/png, image/gif, image/jpeg" required>
                                    
                                    <input type="radio" name="write_option" class="form-control" value="1" required>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="options[]" class="form-control options"  accept="image/png, image/gif, image/jpeg" required>
                                    
                                    <input type="radio" name="write_option" class="form-control" value="2" required>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="options[]" class="form-control options"  accept="image/png, image/gif, image/jpeg" required>
                                    
                                    <input type="radio" name="write_option" class="form-control" value="3" required>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="options[]" class="form-control options"  accept="image/png, image/gif, image/jpeg" required>
                                    
                                    <input type="radio" name="write_option" class="form-control" value="4" required>
                                </div>
                                
                                
                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                                    <div>
                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                                        <!--<button type="button" class="btn btn-primary" onclick="addCell()" style="margin-top: 10px;">Add Options</button>-->
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
    
    // const removeExtroInput = (t) => {
    //     let parent = t.nextSibling;
    //     console.log(t.nextSibling);
    // }
    
    
    const change_type = (val) => {
        let el = document.querySelectorAll(".options");
        el.forEach((item, index)=>{
            if(val == 1){
                item.type='text';
            }else{
                item.type='file';
            }
        })
        
        
    }
    
    const addCell = () => {
        let html = document.querySelector("#main_cell").innerHTML;
        document.querySelector("#submit").insertAdjacentHTML('beforebegin',html);
    }
    
    // This is on load
    
    window.addEventListener('DOMContentLoaded', (event) => {
        getSubCategory();
    });
    
    // This is for choosen
    // $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
    
</script>

<?php include ("includes/footer.php"); ?>   