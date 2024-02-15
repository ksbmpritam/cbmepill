<?php
include("includes/header.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");


if (isset($_POST['submit'])) {
    //Main Image
    $type = filter($_POST['type']);
    $photo = $_FILES['photo'];
    
    $name_arr = explode(".",$photo['name']);
    $ext = end($name_arr);
    
    $file_name = time().".".$ext;
    
    if(move_uploaded_file($photo['tmp_name'],"medicines/".$file_name)){
        
        $data = array(
            'name' => $type,
            'photo' => $file_name,
        );
        Insert('medicine_type', $data);
        $_SESSION['msg'] = "Medicine added success";
        header("Location:add_medicine.php");
        exit;
        
    }else{
        $_SESSION['msg'] = "There is some error..";
        header("Location:add_medicine.php");
        exit;
    }
    
}
?>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Add Pills</div>

                </div>

            </div>

            <div class="clearfix"></div>

            <div class="row mrg-top">

                <div class="col-md-12">



                    <div class="col-md-12 col-sm-12">

                        <?php if (isset($_SESSION['msg'])) { ?>

                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                <?php echo $_SESSION['msg']; ?></a>
                            </div>

                        <?php unset($_SESSION['msg']);
                        }
                        ?>

                    </div>

                </div>

            </div>

            <div class="card-body mrg_bottom">

                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">

                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Type</label>
                            <input name="type" type="text" class="form-control" required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Photo</label>
                            <input name="photo" type="file" accept="image/png, image/jpg, image/jpeg" class="form-control" required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
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