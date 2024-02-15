<?php
include ("includes/header_teacher.php");
require ("includes/function.php");
require ("language/language.php");
require_once ("thumbnail_images.class.php");

function file_validation($file_array,$file_extensions,$file_size){
	//File details here
	$file_name = $file_array['name'];
	$file_type = $file_array['type'];
	$file_tem_name = $file_array['tmp_name'];
	$file_error = $file_array['error'];
	$file_size_get = $file_array['size']; // this is in bytes, 1mb = 10,000,00 bytes
	//file extensions here
	$file_name_exs = explode('.', $file_name);
	$file_exs = strtolower(end($file_name_exs)); 
	//validation start
	if(!$file_error){
			if(in_array($file_exs, $file_extensions)) {
					if($file_size_get <= $file_size){
						return true;	
					}else{
						return false;
					}
			}else{
				return false;
			}
	}else{
		return false;
	}
}
// Here you can add what type of extensions you want and file size in bytes
$file_extensions = ['png','jpg','jpeg','mp4'];
$file_size = 1024 * 1024 * 10; //1 mb, 1024 * 1024


if (isset($_POST['submit'])) {
    //Main Image
    // $category = filter($_POST['category']);
    $subcategory = intval(filter($_POST['subcategory']));
  
    $slide_description = filter($_POST['slide_description']);
    
    $count = count($_FILES['photos']['name']);
    
    $slide_id = strtoupper(uniqid());
    
    
      $category = array();
     $sql_cat = "SELECT category_id From `sub_categories` where id = $subcategory ";
    
     $query_cat = mysqli_query($mysqli,$sql_cat);
     while ($row_query_cat = mysqli_fetch_assoc($query_cat)){
        $category['c_id'] =  $row_query_cat['category_id'];
     };

   
    
               if($count > 2 && $count != '0'){
            $_SESSION['msg'] = "Only 2 photos are allowed..";
            header("Location:add_tik_tok.php");
            exit;
        }else{
        for($i=0;$i<$count;$i++){
            $filename = $i.time().$_FILES['photos']['name'][$i];
            $file_name = array(
                'name' => $_FILES['photos']['name'][$i],
                'type' => $_FILES['photos']['type'][$i],
                'tmp_name' => $_FILES['photos']['tmp_name'][$i],
                'size' => $_FILES['photos']['size'][$i]
            );
            
            if(!file_validation($file_name, $file_extensions, $file_size)){
                ?>
                    <script>
                        alert("Invalid file Size");
                    </script>
                <?php
                continue;
            }
            
            // Upload file
            move_uploaded_file($_FILES['photos']['tmp_name'][$i],'slides/'.$filename);
            $data = array(
                'c_id' => $category['c_id'],
                'sc_id' => $subcategory,
                'description' => $slide_description,
                'image' => $filename,
                'slide_id' => $slide_id,
                'orders' => 0
                );
            Insert('slides', $data);
           
        }
        
     
            $_SESSION['msg'] = "Think High Added Success";
         header("Location:all_think_high_teacher.php");
         exit;
    }
    
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

                    <div class="page_title">Add Think High</div>

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
                                <label>Sub Category</label>
                                <select class="form-control" name="subcategory" required>
                                      <option value="">Select</option>
                                    <?php 
                                     $sql_sub_cat_id = "SELECT id, teacher_id ,name,category_id
                                        FROM sub_categories
                                        WHERE FIND_IN_SET('$userValue', teacher_id);";
                                    $query_sub_cat = mysqli_query($mysqli, $sql_sub_cat_id);
                                  
                                    while ($row_sub_cat_id = mysqli_fetch_assoc($query_sub_cat)) {
                                        ?>
                                        <option value="<?= $row_sub_cat_id['id'] ?>"><?= $row_sub_cat_id['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 top_margin">
                                    <div>
                                        <label for="something">Write Something about Think High..</label>
                                        <textarea class="form-control" name="slide_description" id="something" rows="3"></textarea>
                                    </div>
                                </div>
                                        
                                
                                <div id="main_cell">
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-12 top_margin">
                                        <label>Images</label>
                                        <small>Upload Image or Video (Resolution 1080x2160)</small>
                                        <input id="file" type="file" name="photos[]" required class="form-control-file" accept="image/png,image/jpeg,video/mp4">
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
            console.log(val);
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
<script>


</script>
