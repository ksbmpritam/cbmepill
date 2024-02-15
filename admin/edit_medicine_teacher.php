<?php
include("includes/header_teacher.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM `medicine_type` WHERE id='$id'";
    $query = mysqli_query($mysqli,$sql);
    $old_data = mysqli_fetch_assoc($query);
}


if (isset($_POST['submit'])) {
    //Main Image
    $id = filter($_POST['id']);
    $type = filter($_POST['type']);
    $photo = $_FILES['photo'];
    
    if(!empty($photo['name'])){
        
        $name_arr = explode(".",$photo['name']);
        $ext = end($name_arr);
        
        $file_name = time().".".$ext;
        
        if(move_uploaded_file($photo['tmp_name'],"medicines/".$file_name)){
            
            $data = array(
                'name' => $type,
                'photo' => $file_name,
            );
            Update('medicine_type', $data,"WHERE id='$id'");
            $_SESSION['msg'] = "Medicine Updated success";
            header("Location:all_medicine_teacher.php");
            exit;
            
        }else{
            $_SESSION['msg'] = "There is some error..";
            header("Location:all_medicine_teacher.php");
            exit;
        }
        
    }else{
        
        $data = array(
            'name' => $type,
        );
        Update('medicine_type', $data,"WHERE id='$id'");
        $_SESSION['msg'] = "Medicine Updated success";
        header("Location:all_medicine_teacher.php");
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
                    <input type="hidden" name="id" value="<?=$id?>">
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Type</label>
                            <input name="type" type="text" class="form-control" value="<?=$old_data['name']?>" required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Photo</label>
                            <input name="photo" type="file" accept="image/png, image/jpg, image/jpeg" class="form-control">
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <img src="medicines/<?=$old_data['photo']?>?>" style="height:150px;width:200px;">
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