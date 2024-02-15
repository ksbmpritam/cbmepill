<?php

include("includes/header.php");



require("includes/function.php");

require("language/language.php");



require_once("thumbnail_images.class.php");



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
        
        'amount' => 0.00,

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

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title"><?php if (isset($_GET['cat_id'])) { ?>Edit<?php } else { ?>Add<?php } ?> Category</div>

                </div>

            </div>

            <div class="clearfix"></div>

            <div class="row mrg-top">

                <div class="col-md-12">



                    <div class="col-md-12 col-sm-12">

                        <?php if (isset($_SESSION['msg'])) { ?>

                            <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                <?php echo $client_lang[$_SESSION['msg']]; ?></a> </div>

                        <?php unset($_SESSION['msg']);
                        }

                        ?>

                    </div>

                </div>

            </div>

            <div class="card-body mrg_bottom">

                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">

                    <div class="form-group">

                        <label class="col-md-3 control-label">Name :-</label>

                        <div class="col-md-6">

                            <input name="category_name" type="text" class="form-control" value="<?php echo $row['category_name'] ? $row['category_name'] : '' ?>" required>

                        </div>

                    </div>
                    <div class="form-group" style="margin-top: 20px;width: 100%; display: inline-block;">
                        <div class="col-md-3">
                            <label class="control-label">Image</label><br>

                        </div>
                        <div class="col-md-3">
                            <?php $src =  $row['category_image'] ? 'images/' . $row['category_image'] : 'assets/images/no+image.png' ?>
                            <label class="labeled thumbnail" data-toggle="tooltip" title="" data-original-title="Upload product image">
                                <img class="avatar" id="" src="<?php echo $src; ?>" alt="avatar" width="150" height="100">
                                <input type="file" class="sr-only inputfile" name="image" accept="image/*" data-width="" data-height="">
                                <input type="hidden" name="category_image" class="default imghidden">
                            </label>


                        </div>

                        <div class="col-md-3">
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-md-3 control-label">Discription :-</label>

                        <div class="col-md-6">

                            <textarea name="discription" class="form-control ckeditor"><?php echo $row['subject_des'] ? $row['subject_des'] : '' ?> </textarea>

                        </div>

                    </div>



                    <input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'] ? $_GET['cat_id'] : '' ?>">

                    <div class="form-group">

                        <div class="col-md-9 col-md-offset-3">

                            <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>

                        </div>

                    </div>

            </div>

        </div>

        </form>

    </div>

</div>

</div>

</div>



<?php include("includes/footer.php"); ?>