<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");
$statusMsg = '';
// File upload path
date_default_timezone_set('Asia/Kolkata');
$targetDir = "upload_books/page/";
//$fileName = basename($_FILES["book_cover_image"]["name"]);
$fileNa=date('Y-m-d:hi').'_'.$_FILES["page_image"]["name"];
$fileName=basename($fileNa);

$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["edit"]) && isset($_GET['id'])){
        
        $id=$_GET['id'];
        $page_no=$_POST['page_no'];
	    $page_type=$_POST['page_type'];
	    
	    $cur_date=date('Y-m-d h:i:s');
	    // if image update
     if(!empty($_FILES["page_image"]["name"]))
     {
         // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["page_image"]["tmp_name"], $targetFilePath)){
        
           //update book
           
           $sql="update book_contents SET page_no='$page_no',page_type='$page_type',page_image='$fileName',updated_date='$cur_date' where id='$id'";
        //   echo $sql;
        //   exit;
            $update=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
            if($update){
                //$statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $statusMsg = "Book Contents Update   successfully !";
                
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
     }
     else
     {
         $sql1="update  book_contents SET page_no='$page_no',page_type='$page_type',updated_date='$cur_date' where id='$id'";
            $update1=mysqli_query($mysqli,$sql1) or die(mysqli_error($mysqli));
            if($update1){
                //$statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $statusMsg = "Book Contents Update   successfully !";
                
            }
            else
            {
                $statusMsg = "Book Contents is not Update   successfully !";
            }
     }
    
}else{
    //$statusMsg = 'Please select a file to upload.';
}

// Display status message
//echo $statusMsg;
    
//     $query=mysqli_query($mysqli,$sql);
//     if($query){
//         echo"dfasr";
//         echo"<script>alert('Update Successfully');
//         window.location.href = 'coupons.php';
//         </script>";
// 	  }
	
$id=$_GET['id'];
$sqli="SELECT * from book_contents where id='$id'";
$data=mysqli_query($mysqli,$sqli);
$row=mysqli_fetch_assoc($data);

$p_cat=$row['page_type'];


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>


<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Edit Book Contents</div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
              <div class="col-md-12 col-sm-12">
                <?php if($statusMsg){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $statusMsg ; ?></a> </div>
                <?php unset($statusMsg);}?>	
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
           <form class="form form-horizontal" method="POST" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Book ID :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="book_id" id="Book_id"  value="<?php echo $row['book_id']; ?>"  disabled>
                  </div>
                  <!--<label class="col-sm-2 control-label">Book Title:</label>-->
                  <!--<div class="col-sm-4">-->
                  <!--  <input type="text" class="form-control "   id="Book_title" value=" Enter Book Title" disabled="disabled" >-->
                  <!--</div>-->
                   <label class="col-sm-2 control-label">Page Number :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="page_no"  value="<?php echo $row['page_no']; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Page Type:</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="page_type" >
                    <option value selected disabled>Please Select Page Type</option>
                    <option value="Paid" <?php if($p_cat=='Paid') echo 'selected';?>>Paid</option>
                    <option value="Free" <?php if($p_cat=='Free') echo 'selected';?>>Free</option>
                    </select>
                  </div>
                  <label class="col-sm-1 control-label">Book Page Image :</label>
                  <div class="col-sm-2">
                         <div class="block_wallpaper add_wall_category"> 
                         <span><img src="upload_books/page/<?php echo $row['page_image'];?>" alt="" style="height:50px;" /></span>
                        </div>
                        </div>
                  <div class="col-sm-3">
                    <input type="file" class="form-control" name="page_image"   >
                  </div>
                </div>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-1">
                      <button type="submit" name="edit" class="btn btn-sm btn-primary">Save</button>
                      <button type="reset"  class="btn btn-sm btn-danger">Reset</button>
                      <a href="books_contents.php" class="btn btn-sm btn-success">Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
