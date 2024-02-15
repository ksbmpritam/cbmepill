<?php
include ("includes/header.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");


if (isset($_POST['submit'])) {
    //Main Image
    $category = filter($_POST['category']);
    $subcategory = filter($_POST['subcategory']);
    $doctor_said = str_replace("'","\'",$_POST['doctor']);
    
    $count = count($_FILES['photos']['name']);
    
    for($i=0;$i<$count;$i++){
        $filename = $i.time().$_FILES['photos']['name'][$i];
        $file_type = $_FILES['photos']['type'][$i];
        // Upload file
        move_uploaded_file($_FILES['photos']['tmp_name'][$i],'games_photos/'.$filename);
        $data = array(
            'c_id' => $category,
            'sc_id' => $subcategory,
            'doctor_said' => $doctor_said,
            'file' => $filename,
            'file_type' => $file_type,
            );
        Insert('prescription', $data);
       
    }
    
    $_SESSION['msg'] = "Prescription Added Success";
    header("Location:add_prescription.php");
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

                    <div class="page_title">Add Prescription</div>

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
                                    <label>Category</label>
                                    <select class="form-control" onchange="getSubCategory()" id="category" name="category">
                                        <?php
                                            $sql = "SELECT cid,category_name FROM `tbl_category` ORDER BY category_name";
                                            $query = mysqli_query($mysqli,$sql);
                                            while($row = mysqli_fetch_assoc($query)){
                                                ?>
                                                    <option value="<?=$row['cid']?>"><?=$row['category_name']?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label>Sub Category</label>
                                    <select class="form-control" id="subCategory" name="subcategory">
                                    </select>
                                </div>
                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <label for="something">Type Something</label>
                                    <textarea class="form-control" name="doctor" required id="something" rows="3"></textarea>
                                </div>
                                        
                                
                                <div id="main_cell">
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-12 top_margin">
                                        <label>File</label>
                                        <input id="file" type="file" name="photos[]" class="form-control-file" accept="image/png, image/gif, image/jpeg, application/pdf" required>
                                    </div>
                                    
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
        getSubCategory();
    });
    
</script>

<?php include ("includes/footer.php"); ?>       
<script type="text/javascript" src="assets/js/pekeUpload.js"></script>
<script>

$(document).ready(function() {

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