<?php
include("includes/header.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

if( isset($_GET['id']) && !empty($_GET['id']) ){
    $id = $_GET['id'];
    $sql = "SELECT * FROM `pills` WHERE id='$id'";
    $query = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_assoc($query);
    // print_r($row);
}


if (isset($_POST['submit'])) {
    //Main Image
    $pill_name = filter($_POST['pill_name']);
    $pill_code = $_POST['pill_code'];
    $pill_description = str_replace("'", "\'", $_POST['pill_description']);
    $pill_benefits = str_replace("'", "\'", $_POST['pill_benefits']);
    $pillType = $_POST['pillType'];
    $id = $_POST['id'];

    $data = array(
        'pill' => $pill_name,
        'pill_code' => $pill_code,
        'pill_description' => $pill_description,
        'pill_benefits' => $pill_benefits,
        'type' => $pillType,
    );
    Update('pills', $data,"WHERE id='$id'");
    $_SESSION['msg'] = "Pill Updated success";
    header("Location:all_pill.php");
    exit;
}
?>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Edit Pill</div>

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
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Pill Name</label>
                            <input name="pill_name" type="text" class="form-control" value="<?=$row['pill']?>" required>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Pill Code</label>
                            <input name="pill_code" type="text" class="form-control" required value="<?=$row['pill_code']?>" disabled>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Pill Description</label>
                            <textarea name="pill_description" type="text" class="form-control" required><?=$row['pill_description']?></textarea>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Pill Benefits</label>
                            <textarea name="pill_benefits" type="text" class="form-control" required><?=$row['pill_benefits']?></textarea>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Type</label>
                            <select class="form-control" name="pillType" required>
                                <?php
                                    $type = ["Pill","Injection","Iv fluid","Receptor","Antibody","Bacteria","Virus"];
                                    
                                    $med_sql = "SELECT * FROM `medicine_type`";
                                    $med_query = mysqli_query($mysqli,$med_sql);
                                    
                                    while($med_row = mysqli_fetch_assoc($med_query)){
                                        if($row['type'] == $med_row['id']){
                                            echo "<option selected value='".$med_row['id']."'>".$med_row['name']."</option>";
                                        }else{
                                            echo "<option value='".$med_row['id']."'>".$med_row['name']."</option>";
                                        }
                                    }
                                ?>
                            </select>
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