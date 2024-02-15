<?php
include("includes/header.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

$cid = filter($_GET['cid']);
$sub_id = filter($_GET['sub_id']);
$id = filter($_GET['id']);
$slide_id = filter($_GET['slide_id']);

$sql = "SELECT gi.file,gi.game_case,tc.category_name,sc.name,sc.id as subid FROM game_intro gi JOIN tbl_category tc JOIN sub_categories sc 
WHERE gi.c_id=tc.cid AND gi.sc_id=sc.id AND gi.c_id='$cid' AND gi.sc_id='$sub_id' AND gi.id='$id'";
$query = mysqli_query($mysqli, $sql);
$row_get = mysqli_fetch_assoc($query);



if (isset($_POST['submit'])) {
    //Main Image
    $id = filter($_POST['slide_id']);
    $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    $game_case = $_POST['game_case'][0];

    if (isset($_FILES['file']['name'][0]) && !empty($_FILES['file']['name'][0])) {
        $count = count($_FILES['file']['name']);

        for ($i = 0; $i < $count; $i++) {
            $filename = "in" . $i . time() . $_FILES['file']['name'][$i];
            $game_case = $_POST['game_case'][$i];
            $file_type = $_FILES['file']['type'][$i];
            // Upload file
            move_uploaded_file($_FILES['file']['tmp_name'][$i], 'games_photos/' . $filename);
            $data = array(
                'c_id' => $category,
                'sc_id' => $subcategory,
                'file' => $filename,
                'file_type' => $file_type,
                'game_case' => $game_case,
                'slide_id' => $id,
            );
            Insert('game_intro', $data);
        }
    } else {
        $sql = "UPDATE `game_intro` SET `c_id`='$category',`sc_id`='$subcategory',`game_case`='$game_case' WHERE slide_id='$id'";
        mysqli_query($mysqli, $sql);
    }





    $_SESSION['msg'] = "Game Intro Updated Success";
    header("Location:all_game_intro.php");
    exit;
}

?>
<link rel="stylesheet" href="assets/css/custom.css">

<style>
    .top_margin {
        margin: 15px 0 !important;
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

                    <div class="page_title">Add Game Intro</div>

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
                    <input type="hidden" name="slide_id" value="<?=$slide_id?>">

                    <div class="row px-2">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Category</label>
                                <select class="form-control" onchange="getSubCategory()" id="category" name="category">
                                    <?php
                                    $sql = "SELECT cid,category_name FROM `tbl_category`";
                                    $query = mysqli_query($mysqli, $sql);
                                    while ($row = mysqli_fetch_assoc($query)) {

                                        if ($row_get['category_name'] == $row['category_name']) {
                                            $select = "selected";
                                        } else {
                                            $select = "";
                                        }

                                    ?>
                                        <option <?= $select ?> value="<?= $row['cid'] ?>"><?= $row['category_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div>
                                <label>Sub Category</label>
                                <select class="form-control" id="subCategory" name="subcategory">
                                    <option value="<?= $row_get['subid'] ?>"><?= $row_get['name'] ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                            <label for="something">Case</label>
                            <input type="text" class="form-control" name="game_case[]" value="<?= $row_get['game_case'] ?>" value id="something" />
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Images</label>
                            <input id="file" type="file" name="file[]" class="form-control-file" accept="image/png, image/gif, image/jpeg, video/mp4">
                        </div>
                        
                            <?php
                            
                            $sql1 = "SELECT id,file,file_type FROM `game_intro` WHERE slide_id='$slide_id'";   
                            $query1 = mysqli_query($mysqli,$sql1);
                            
                            while($row1 = mysqli_fetch_assoc($query1)){
                                
                                if($row1['file_type'] == "video/mp4"){
                                    ?>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            
                                            <video src="games_photos/<?=$row1['file']?>" controls class="all_img">
                                              Your browser does not support the video tag.
                                            </video>
                                            
                                            <i class="fa fa-trash fa-2x delete" title="delete" onclick="deletePhoto(this,'<?=$row1['id']?>')" aria-hidden="true"></i>
                                        </div>
                                    <?php
                                }else{
                                    ?>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <img src="games_photos/<?=$row1['file']?>" class="all_img"/>
                                            <i class="fa fa-trash fa-2x delete" title="delete" onclick="deletePhoto(this,'<?=$row1['id']?>')" aria-hidden="true"></i>
                                        </div>
                                    <?php
                                }
                                
                            }
                            
                            ?>

                        <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                            <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                            <!--<button type="button" class="btn btn-primary" onclick="addCell()" style="margin-top: 10px;">Add More</button> -->
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

    const deletePhoto = async (el,id) => {
        let a = confirm("Are you sure you want to delete this file..");
        if(a){
            try {
                let val = id;
                let url = `delete_game_intro_file.php?id=${val}`;
                let response = await fetch(url);
                let data = await response.text();
                el.parentElement.remove();
            } catch (error) {
                console.log(`The Error is ${error}`);
            }
        }
    }

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

    let count = 1;
    const addCell = () => {
        let html = `
            <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                <label for="something">Case</label>
                <input type="text" class="form-control" name="game_case[]" id="something" />
            </div>
                
            <div class="col-lg-12 col-md-12 col-sm-12">
                <label>Images</label>
                <input id="file" type="file" name="file[]" class="form-control-file" accept="image/png, image/gif, image/jpeg, video/mp4" required>
            </div>
        `;
        if (count <= 3) {
            document.querySelector("#submit").insertAdjacentHTML('beforebegin', html);
        } else {
            alert("Max Limit Reached");
        }
        count++;
    }

    // This is on load

    window.addEventListener('DOMContentLoaded', (event) => {
        // getSubCategory();
    });

    // This is for choosen
    // $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
</script>

<?php include("includes/footer.php"); ?>
<script type="text/javascript" src="assets/js/pekeUpload.js"></script>
<script>
    $(document).ready(function() {

        // $("#file").pekeUpload(
        //     {
        //         onSubmit:true,
        //         limit:4,
        //         bootstrap:true,
        //         dragMode:true

        //     }
        // );

        // $("#file1").pekeUpload(
        //     {
        //         onSubmit:true,
        //         bootstrap:true,
        //         dragMode:true

        //     }
        // );

    });
</script>