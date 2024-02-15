<?php
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");

$id = $_GET['id'];
$image = $_GET['image'];
$pill = $_GET['pill'];
$benefits = $_GET['benefits'];
$type = $_GET['type'];


if (isset($_POST['submit'])) {
    //Main Image
    //print_r($_POST);die;
    $id = filter($_POST['id']);
    $image_id = filter($_POST['image_id']);
    $benefits = filter($_POST['benefitsp']);
    $type = filter($_POST['type']);
    $pill_id = $_POST['pill_id'];
    
    $sql = "UPDATE `pill_benefits` SET `image_id`='$image_id',`pill_id`='$pill_id',`benefits`='$benefits',`type`='$type' WHERE id='$id'";
    
    if(mysqli_query($mysqli,$sql)){
        $_SESSION['msg'] = "Updated success";
        header("Location:all_pill_benefits_teacher.php");
        exit;
    }
    
}
?>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Pill Benefits</div>

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
                
                <img src="games_photos/<?=$image?>" id="img" style="width:200px!important;margin: 0 0 20px;">
                
                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                
                <input type="hidden" value="<?=$id?>" name="id">
                
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label>Select Image</label>
                                    <select class="form-control" name="image_id" onchange="show_img(this.value)">
                                    <option value="">Select</option>
                                    <?php
                                        $sql = "SELECT id,photos FROM `game_photos`";
                                        $query = mysqli_query($mysqli, $sql);
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            
                                            if($image == $row['photos']){
                                                $sel = "selected";
                                            }else{
                                                $sel = "";
                                            }
                                            
                                    ?>
                                        <option <?=$sel?> value="<?=$row['id'] ?>"><?=$row['photos'] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label>Select Pill</label>
                                    <select class="form-control" name="pill_id">
                                    <?php
                                    $sql = "SELECT id,pill FROM `pills`";
                                    $query = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        if($pill == $row['pill']){
                                            $sel = "selected";
                                        }else{
                                            $sel = "";
                                        }
                                    ?>
                                    <option <?=$sel?> value="<?=$row['id'] ?>"><?=$row['pill'] ?></option>
                                    <?php
                                    }
                                    ?> 
                                            </select>                           </div>
                                            
                                            
                                    <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                        <label>Pill Benefits</label>
                                        <textarea class="form-control" name="benefitsp" required><?=$benefits?></textarea>
                                    </div>
                                     
                                    <div class="col-lg-12 col-md-12 col-sm-12 margin_top">
                                        <label>Type</label>
                                        <select class="form-control" name="type">
                                            <?php
                                            
                                                $bn = ["Benefits","Note"];
                                                foreach($bn as $obn){
                                                    if($type == $obn){
                                                        $sel = "selected";
                                                    }else{
                                                        $sel = "";
                                                    }
                                                    echo "<option $sel>$obn</option>";
                                                }
                                            ?>
                                            
                                        </select>                           
                                    </div> 
                                           
                                            
                                            <div class="form-group">

<div class="col-md-6 col-md-offset-1">

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

<script>
    
    const show_img = async (t) => {
        try {
            let val = t;
            let url = `get_img_src.php?id=${val}`;
            let response = await fetch(url);
            let data = await response.text();
            if(data.indexOf(".vish") > -1){
                document.querySelector('#img').src = "images/no_image_selected.png";
            }else{
                document.querySelector('#img').src = data;
            }
        } catch (error) {
            console.log(`The Error is ${error}`);
        }
    }
    
</script>

<?php include ("includes/footer.php"); ?>       