<?php
include ("includes/header.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");

$id = filter($_GET['id']);
$sql = "SELECT * FROM `prescription_new` WHERE id='$id'";
$query = mysqli_query($mysqli,$sql);
$old_data = mysqli_fetch_assoc($query);

#sub category
$sub_sql = "SELECT id,name FROM `sub_categories` WHERE id='".$old_data['sc_id']."'";
$sub_query = mysqli_query($mysqli,$sub_sql);
$sub_data = mysqli_fetch_assoc($sub_query);

if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_POST);
    // die;
    $id = filter($_POST['id']);
    $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    $kase = str_replace("'","\'",$_POST['kase']);
    $pill_options = implode('|',$_POST['pill_options']);
    $right_options = implode('|',$_POST['right_options']);
    $suggesstions = filter($_POST['suggesstions']);
    $right_suggesstions = filter($_POST['right_suggesstions']);
    $description = filter($_POST['description']);
    
    
    $data = array(
        'c_id' => $category,
        'sc_id' => $subcategory,
        'kase' => $kase,
        'options' => $pill_options,
        'right_options' => $right_options,
        'suggestions' => $suggesstions,
        'right_suggestions' => $right_suggesstions,
        'description' => $description,
    );
            
    Update('prescription_new', $data,"WHERE id='$id'");
    $_SESSION['msg'] = "Prescription Updated Success";
    header("Location:all_prescription_new.php");
    exit;
}

?>
<link rel="stylesheet" href="assets/css/custom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">


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

                    <div class="page_title">Edit Prescription</div>

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
                            
                            <input type="hidden" value="<?=$id?>" name="id">
                            
                            <div class="row px-2">
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label>Category</label>
                                    <select class="form-control" onchange="getSubCategory()" id="category" name="category" required>
                                        <?php
                                            $sql = "SELECT cid,category_name FROM `tbl_category` ORDER BY category_name";
                                            $query = mysqli_query($mysqli,$sql);
                                            while($row = mysqli_fetch_assoc($query)){
                                                
                                                if($old_data['c_id'] == $row['cid']){
                                                    $sel = "selected";
                                                }else{
                                                    $sel = "";
                                                }
                                                
                                                ?>
                                                    <option <?=$sel?> value="<?=$row['cid']?>"><?=$row['category_name']?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label>Sub Category</label>
                                    <select class="form-control" id="subCategory" name="subcategory" required>
                                        <option value="<?=$sub_data['id']?>" selected><?=$sub_data['name']?></option>
                                    </select>
                                </div>
                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <label for="something">Case</label>
                                    <textarea class="form-control" rows="4" name="kase" required id="something" rows="3"><?=$old_data['kase']?></textarea>
                                </div>
                                        
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label>Option Pills</label>
                                    <select class="form-control chosen-select" id="pill_option" name="pill_options[]" required multiple>
                                        <?php
                                            $sql = "SELECT * FROM `pills` ORDER BY pill";
                                            $query = mysqli_query($mysqli,$sql);
                                            while($row = mysqli_fetch_assoc($query)){
                                                
                                                $options = explode("|",$old_data['options']);
                                                
                                                if(in_array($row['id'],$options)){
                                                    $sel = "selected";
                                                }else{
                                                    $sel = "";
                                                }
                                                
                                                ?>
                                                    <option value="<?=$row['id']?>" <?=$sel?>><?=$row['pill']?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label>Right Pills</label>
                                    <select class="form-control chosen-select" id="category" name="right_options[]" required multiple>
                                        <?php
                                            $sql = "SELECT * FROM `pills` ORDER BY pill";
                                            $query = mysqli_query($mysqli,$sql);
                                            while($row = mysqli_fetch_assoc($query)){
                                                
                                                $options = explode("|",$old_data['right_options']);
                                                
                                                if(in_array($row['id'],$options)){
                                                    $sel = "selected";
                                                }else{
                                                    $sel = "";
                                                }
                                                
                                                ?>
                                                    <option value="<?=$row['id']?>" <?=$sel?>><?=$row['pill']?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <label for="something">Right Suggestions</label>
                                    <small>Separate By comma</small>
                                    <textarea class="form-control" rows="4" name="right_suggesstions" required rows="3"><?=$old_data['right_suggestions']?></textarea>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <label for="something">All Suggestions</label>
                                    <small>Separate By comma</small>
                                    <textarea class="form-control" rows="4" name="suggesstions" required id="vish" rows="3"><?=$old_data['suggestions']?></textarea>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <label for="something">Description</label>
                                    <textarea class="form-control" rows="4" name="description" required id="something" rows="3"><?=$old_data['description']?></textarea>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
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
    
    // This is on load
    
    window.addEventListener('DOMContentLoaded', (event) => {
        // getSubCategory();
    });
    
</script>

<?php include ("includes/footer.php"); ?>       
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script type="text/javascript" src="assets/js/pekeUpload.js"></script>
<script>

$(document).ready(function() {
    
    $(".chosen-select").chosen({
        "no_results_text": "Oops, nothing found!",
    });
    
    // $("#file").pekeUpload(
    //     {
    //         onSubmit:true,
    //         limit:1,
    //         bootstrap:true,
    //         dragMode:true

    //     }
    // );
    
});

</script>