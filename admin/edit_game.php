<?php
include ("includes/header.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");

$id = filter($_GET['id']);
$cid = filter($_GET['c_id']);
$scid = filter($_GET['sc_id']);
$sql = "SELECT tc.category_name,sc.name,tc.cid,sc.id FROM tbl_category tc JOIN sub_categories sc WHERE tc.cid='$cid' AND sc.id='$scid'";
$query = mysqli_query($mysqli,$sql);
$old_data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    //Main Image
    $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    
    $count = count($_FILES['photos']['name']);
    
    for($i=0;$i<$count;$i++){
        $filename = $i.time().$_FILES['photos']['name'][$i];
        // Upload file
        move_uploaded_file($_FILES['photos']['tmp_name'][$i],'games_photos/'.$filename);
        $data = array(
            'c_id' => $category,
            'sc_id' => $subcategory,
            'photos' => $filename,
            );
        Insert('game_photos', $data);
       
    }
    
    $_SESSION['msg'] = "Photos Added Success";
    header("Location:all_games.php");
    exit;
}

?>
<style>
    .top_margin{
        margin: 15px 0!important;
    }
    .all_img{
        width:250px!important;
        height:200px!important;
        margin:10px 0!important;
    }
    .delete{
        position: absolute;
        bottom: 12px;
        right: 90px;
        color: #b94848;
        cursor:pointer;
    }
</style>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Edit Game</div>

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
                            
                            <input type="hidden" name="c_id" value="<?=$id?>">
                            <div class="row px-2">
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label>Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option selected value="<?=$old_data['cid']?>"><?=$old_data['category_name']?></option>
                                    </select>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label>Sub Category</label>
                                    <select class="form-control" id="subCategory" name="subcategory">
                                        <option selected value="<?=$old_data['id']?>"><?=$old_data['name']?></option>
                                    </select>
                                </div>
                                
                                    
                                <div class="col-lg-9 col-md-9 col-sm-12 top_margin">
                                    <label>Images</label>
                                    <input id="file" type="file" name="photos[]" class="form-control-file" accept="image/png, image/gif, image/jpeg" multiple="multiple" required>
                                </div>
                                
                                    
                                <?php
                                    
                                    $sql1 = "SELECT id,photos FROM `game_photos` WHERE c_id='$cid' AND sc_id='$scid'";
                                    $query1 = mysqli_query($mysqli,$sql1);
                                    
                                    while($row = mysqli_fetch_assoc($query1)){
                                        ?>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <img src="games_photos/<?=$row['photos']?>" class="all_img"/>
                                                <i class="fa fa-trash fa-2x delete" title="delete" onclick="deletePhoto(this,'<?=$row['id']?>')" aria-hidden="true"></i>
                                            </div>
                                        <?php
                                    }
                                
                                ?>    
                                
                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                                    <div>
                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                                        <button type="button" class="btn btn-primary" style="margin-top: 10px;" onclick="history.back()">Back</button>
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
<script>
    const deletePhoto = async (el,id) => {
        let a = confirm("Are you sure you want to delete this photo..");
        if(a){
            try {
                let val = id;
                let url = `delete_photo.php?id=${val}`;
                let response = await fetch(url);
                let data = await response.text();
                el.parentElement.remove();
            } catch (error) {
                console.log(`The Error is ${error}`);
            }
        }
    }
</script>
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
    
});

</script>