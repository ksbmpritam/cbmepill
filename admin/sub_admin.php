<?php
include("includes/header.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

function beautify($str){
    $str = str_replace('_',' ',$str);
    $str = ucwords($str);
    return $str;
}

$permissions = array('show_category','add_category','edit_category');

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

    $data = array(
        'category_name' => $_POST['category_name'],
        'category_image' => $category_image,
        'subject_des' => $_POST['discription'],
    );

    $qry = Insert('tbl_category', $data);

    $_SESSION['msg'] = "10";
    header("Location:manage_category.php");
    exit;
}

if (isset($_GET['cat_id'])) {
    $qry = "SELECT * FROM tbl_category where cid='" . $_GET['cat_id'] . "'";
    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit']) and isset($_POST['cat_id'])) {
    $img_res = mysqli_query($mysqli, 'SELECT * FROM tbl_category WHERE cid=' . $_GET['cat_id'] . '');
    $img_res_row = mysqli_fetch_assoc($img_res);
    //Main Image
    $tpath1 = 'images/';

    if (!empty($_POST['category_image'])) {
        if ($img_res_row['category_image'] && file_exists($tpath1 . $img_res_row['category_image'])) {
            unlink($tpath1 . $img_res_row['category_image']);
        }

        $img_res = upload_img($tpath1, $_POST['category_image']);
        // print_r($img_res);die;
        if (!$img_res['error']) {
            $category_image = $img_res['name'];
        }
    }

    $data = array(
        'category_name' => $_POST['category_name'],
        'category_image' => $category_image,
        'subject_des' => $_POST['discription'],
    );

    $category_edit = Update('tbl_category', $data, "WHERE cid = '" . $_POST['cat_id'] . "'");
    $_SESSION['msg'] = "11";
    header("Location:add_category.php?cat_id=" . $_POST['cat_id']);
    exit;
}

?>
<style>
    label {
        font-weight: unset;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title" style="font-weight: bold;">Create Sub Admin</div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="card-body mrg_bottom">
                
                    <div class="row">
                <form action="<?=$_SERVER['PHP_SELF']?>" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" placeholder="Name" type="text" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="email" placeholder="E-Mail" type="email" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="password" placeholder="Password" type="text" class="form-control" required>
                            </div>
                        </div>
                        
                        <h5 class="my-2">Permissions</h5>
                        
                        <?php
                            foreach($permissions as $permission){
                                ?>
                                <div class="col-md-2">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="<?=$permission?>">
                                        <label class="form-check-label" for="<?=$permission?>"><?=beautify($permission)?></label>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-sm btn-primary" style="margin-top: 10px;">Save</button>
                            </div>
                        </div>
                        

                </form>
                    </div>
                
                
            </div>

        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>