<?php
include ("includes/header.php");
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
    header("Location:all_games.php");
    exit;
}

if (isset($_POST['submit'])) {
    //Main Image
    $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    // $about_game = str_replace("'","\'",$_POST['about_game']);
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
                                        <label>Category</label>
                                        <select class="form-control" onchange="getSubCategory()" id="category" name="category">
                                            <?php
                                                $sql = "SELECT cid,category_name FROM `tbl_category`";
                                                $query = mysqli_query($mysqli,$sql);
                                                while($row = mysqli_fetch_assoc($query)){
                                                    ?>
                                                        <option value="<?=$row['cid']?>"><?=$row['category_name']?></option>
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
                                            <!--<option>Test</option>-->
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <!--<div class="col-lg-12 col-md-12 col-sm-12 top_margin">-->
                                <!--    <div>-->
                                <!--        <label for="something">Write Something about Game..</label>-->
                                <!--        <textarea class="form-control" name="about_game" id="something" rows="3"></textarea>-->
                                <!--    </div>-->
                                <!--</div>-->
                                        
                                
                                <div id="main_cell">
                                    
                                    <!--<div class="col-lg-12 col-md-12 col-sm-12 top_margin">-->
                                    <!--    <label>Intro Images</label>-->
                                    <!--    <input id="file1" type="file" name="photos1" class="form-control-file" accept="image/png, image/gif, image/jpeg" required>-->
                                    <!--</div>-->
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-12 top_margin">
                                        <label>Images</label>
                                        <input id="file" type="file" name="photos[]" class="form-control-file" accept="image/png, image/gif, image/jpeg" multiple="multiple" required>
                                    </div>
                                    
                                </div>
                                
                                
                                
                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                                    <div>
                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                                        <!-- <button type="button" class="btn btn-primary" onclick="addCell()" style="margin-top: 10px;">Add More Images</button> -->
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
    
    const addCell = () => {
        let html = document.querySelector("#main_cell").innerHTML;
        document.querySelector("#submit").insertAdjacentHTML('beforebegin',html);
    }
    
    // This is on load
    
    window.addEventListener('DOMContentLoaded', (event) => {
        getSubCategory();
    });
    
    // This is for choosen
    // $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
    
</script>

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
