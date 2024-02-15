<?php
include("includes/header.php");
require("includes/function.php");
require("language/language.php");
require_once("thumbnail_images.class.php");

$cid = filter($_GET['cid']);
$sub_id = filter($_GET['sub_id']);
$id = filter($_GET['id']);
$slide_id = filter($_GET['slide_id']);

$sql = "SELECT * FROM slides s JOIN tbl_category tc JOIN sub_categories sc WHERE s.id='$id' AND s.c_id='$cid' AND s.sc_id='$sub_id' AND tc.cid=s.c_id AND sc.id=s.sc_id";
$query = mysqli_query($mysqli, $sql);
$row_get = mysqli_fetch_assoc($query);



if (isset($_POST['submit'])) {
    //Main Image
    $id = filter($_POST['slide_id']);
    $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    $description = $_POST['description'];

    if (isset($_FILES['file']['name'][0]) && !empty($_FILES['file']['name'][0])) {
        $count = count($_FILES['file']['name']);

        for ($i = 0; $i < $count; $i++) {
            $filename = "in" . $i . time() . $_FILES['file']['name'][$i];
            $file_type = $_FILES['file']['type'][$i];
            // Upload file
            move_uploaded_file($_FILES['file']['tmp_name'][$i], 'slides/' . $filename);
            $data = array(
                'c_id' => $category,
                'sc_id' => $subcategory,
                'image' => $filename,
                'description' => $description,
                'slide_id' => $id,
            );
            Update('slides', $data, "WHERE slide_id='$id'");
        }
    } else {
        $sql = "UPDATE `slides` SET `c_id`='$category',`sc_id`='$subcategory',`description`='$description' WHERE slide_id='$id'";
        mysqli_query($mysqli, $sql);
    }





    $_SESSION['msg'] = "Game Intro Updated Success";
    header("Location:all_think_high.php");
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

                    <div class="page_title">Edit</div>

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
                                    $sql = "SELECT cid,category_name FROM `tbl_category` ORDER BY category_name ASC";
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
                                    <option value="<?=$sub_id?>"><?= $row_get['name'] ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                            <label for="something">Write Something about slide..</label>
                            <input type="text" class="form-control" name="description" value="<?= $row_get['description'] ?>" value id="something" />
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Images</label>
                            <small>Upload Image or Video</small>
                            <input id="file" type="file" name="file[]" class="form-control-file" accept="image/png, image/gif, image/jpeg, video/mp4">
                        </div>
                        
                            <?php
                            
                            $sql1 = "SELECT id,image as file FROM `slides` WHERE slide_id='$slide_id'";   
                            $query1 = mysqli_query($mysqli,$sql1);
                            
                            while($row1 = mysqli_fetch_assoc($query1)){
                                
                                if(strpos($row1['file'],".") > 0){
                                    ?>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <img src="slides/<?=$row1['file']?>" class="all_img"/>
                                            <i class="fa fa-trash fa-2x delete" title="delete" onclick="deletePhoto(this,'<?=$row1['id']?>')" aria-hidden="true"></i>
                                        </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <img src="images/no_image_selected.png" class="all_img"/>
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
                let url = `delete_image_file.php?id=${val}`;
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