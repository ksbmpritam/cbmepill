<?php
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");

$id = filter($_GET['id']);
$sql = "SELECT m.id,m.sc_id sc_id,m.title_text,sc.name,tc.category_name,m.title_img,m.options,m.right_option,m.timer,m.why_ans_mcq FROM `mcq` m JOIN tbl_category tc JOIN sub_categories sc WHERE m.c_id=tc.cid AND m.sc_id=sc.id AND m.id='$id'";
$query = mysqli_query($mysqli,$sql);
$old_data = mysqli_fetch_assoc($query);

$options_array = explode("|",$old_data['options']);

if(end(explode(".",$options_array[0])) == "png"){
    $options_is_images = $options_array;
}else{
    $options_is_text = $options_array;
}


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
        $category['category'] =  $row_query_cat['category_id'];
     };
     
    
    if(isset($_FILES['title_image'])){
        $title_image = $_FILES['title_image'];
        
        $title_image_name = time().".png";
        move_uploaded_file($title_image['tmp_name'],"mcq_images/".$title_image_name);
    }else{
        $title_image_name = $_POST['title_image'];
    }
    
    $old_option_image_array = $_POST['options'];
    
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
        
        $photo_new_name_updated_array = array_merge($old_option_image_array,$photo_new_name_array);
        
    }else{
        $photo_new_name_updated_array = $old_option_image_array;
    }
    
    
    
    $data = array(
        'c_id' =>  $category['category'],
        'sc_id' => $subcategory,
        'title_text' => $title_heading,
        'title_img' => $title_image_name,
        'options' => implode("|",$photo_new_name_updated_array),
        'right_option' => $write_option,
        'timer' => $mcq_timer,
           'why_ans_mcq' => $why_ans_mcq,
        );
    Update('mcq', $data,"WHERE id='$id'");
    $_SESSION['msg'] = "Mcq Updated Success";
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

                    <div class="page_title">Edit MCQ</div>

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
                            <input type="hidden" name="id" value="<?=$id?>">
                            
                            <div class="row px-2">
                                
                             
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Sub Category</label>
                                <select class="form-control"  name="subcategory">
                                        <option value="">Select</option>
                                         <?php 
                                     $sql_sub_cat_id = "SELECT id, teacher_id ,name,category_id
                                        FROM sub_categories
                                        WHERE FIND_IN_SET('$userValue', teacher_id);";
                                    $query_sub_cat = mysqli_query($mysqli, $sql_sub_cat_id);
                                  
                                    while ($row_sub_cat_id = mysqli_fetch_assoc($query_sub_cat)) {
                                        ?>
                                        <option value="<?= $row_sub_cat_id['id'] ?>"  <?=  $old_data['sc_id'] == $row_sub_cat_id['id'] ? Selected : ''; ?>><?= $row_sub_cat_id['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                                
                               
                                
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Title</label>
                                        <input type="text" class="form-control" value="<?=$old_data['title_text']?>" name="title_heading">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Title Image</label>
                                        <input type="text" value="<?=$old_data['title_img']?>" onfocus="this.type='file'" class="form-control" name="title_image">
                                        <img src="mcq_images/<?=$old_data['title_img']?>">
                                    </div>
                                </div>
                                
                                
                                
                                 <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Mcq Timer (In seconds..)</label>
                                       <input type="number" min="5" value="<?=$old_data['timer']?>" class="form-control" name="mcq_timer">
                                    </div>
                                </div>
                                
                                 <div class="col-lg-6 col-md-6 col-sm-6 top_margin">
                                    <div>
                                        <label>Why Ans is wright</label>
                                        <input type="text" value="<?=$old_data['why_ans_mcq']?>" class="form-control" name="why_ans_mcq" required  >
                                    </div>
                                </div>
                                
                                
                                
                                <?php
                                    $val = 1;
                                    if(isset($options_is_images)){
                                        
                                        foreach($options_is_images as $img){
                                            
                                            if($old_data['right_option'] == $val){
                                                $checked = "checked";
                                            }else{
                                                $checked = "";
                                            }
                                            
                                            ?>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <img src="mcq_images/<?=$img?>">                                                
                                                <input type="text" name="options[]" class="form-control options" onfocus="this.type='file'" value="<?=$img?>" required>
                                                <input type="radio" name="write_option" class="form-control" value="<?=$val++?>" required <?=$checked?>>
                                            </div>
                                            <?php
                                        }
                                        
                                        ?>
                                        
                                        <?php
                                    }
                                    
                                    if(isset($options_is_text)){
                                        
                                        foreach($options_is_text as $txt){
                                            
                                                if($old_data['right_option'] == $val){
                                                    $checked = "checked";
                                                }else{
                                                    $checked = "";
                                                }
                                                
                                            ?>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" name="options[]" class="form-control options" value="<?=$txt?>" required>
                                                <input type="radio" name="write_option" class="form-control" value="<?=$val++?>" required <?=$checked?>>
                                            </div>
                                            <?php
                                        }
                                        
                                    }
                                
                                ?>
                                 
                                
                                
                                
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
        // getSubCategory();
    });
    
    // This is for choosen
    // $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
    
</script>

<?php include ("includes/footer.php"); ?>   