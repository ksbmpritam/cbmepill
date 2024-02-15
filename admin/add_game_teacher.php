<?php
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");
if (isset($_POST['submit']) and isset($_GET['add'])) {
    //Main Image
    $tpath1 = 'images/';
    if (!empty($_POST['category_image'])) {
        $img_res = upload_img($tpath1, $_POST['category_image']);
        // print_r($img_res);die;
        if (!$img_res['error']) {
            $category_image = $img_res['name'];
        }
    }
    $data = array('category_name' => $_POST['category_name'], 'category_image' => $category_image, 'subject_des' => $_POST['discription'],);
    $qry = Insert('tbl_category', $data);
    $_SESSION['msg'] = "10";
    header("Location:manage_category.php");
    exit;
}

if (isset($_GET['id'])) {
    $del = filter($_GET['id']);
    Delete('game_photos', 'id=' . $del . '');

    $_SESSION['msg'] = "Pill Deleted Success";
    header("Location:all_games_teacher.php");
    exit;
}

if (isset($_POST['submit'])) {
    //Main Image
    // $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    // $about_game = str_replace("'","\'",$_POST['about_game']);
    $count = count($_FILES['photos']['name']);
    
       $category = array();
     $sql_cat = "SELECT category_id From `sub_categories` where id = $subcategory ";
    
     $query_cat = mysqli_query($mysqli,$sql_cat);
     while ($row_query_cat = mysqli_fetch_assoc($query_cat)){
        $category['c_id'] =  $row_query_cat['category_id'];
     };
    
    
    for($i=0;$i<$count;$i++){
        $filename = $i.time().$_FILES['photos']['name'][$i];
        // Upload file
        move_uploaded_file($_FILES['photos']['tmp_name'][$i],'games_photos/'.$filename);
        $data = array(
            'c_id' =>  $category['c_id'],
            'sc_id' => $subcategory,
            'photos' => $filename,
            );
        Insert('game_photos', $data);
       
    }
    
    $_SESSION['msg'] = "Photos Added Success";
    header("Location:all_games_teacher.php");
    exit;
}
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

                    <div class="page_title">Add Game</div>

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
                                        <select class="form-control" id="subCategory" name="subcategory">
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
                                
                            
                                
                                <div id="main_cell">
                                    
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-12 top_margin">
                                        <label>Images</label>
                                        <input id="file" type="file" name="photos[]" class="form-control-file" accept="image/png, image/gif, image/jpeg" multiple="multiple" required>
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

$(document).ready(function() {

    $("#file").pekeUpload(
        {
            onSubmit:true,
            limit:4,
            bootstrap:true,
            dragMode:true

        }
    );
    
    // $("#file1").pekeUpload(
    //     {
    //         onSubmit:true,
    //         bootstrap:true,
    //         dragMode:true

    //     }
    // );

});

</script>
