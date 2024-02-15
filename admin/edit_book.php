<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");
$statusMsg = '';
// File upload path
date_default_timezone_set('Asia/Kolkata');
$targetDir = "upload_books/cover/";
//$fileName = basename($_FILES["book_cover_image"]["name"]);
$fileNa=date('Y-m-d:hi').'_'.$_FILES["book_cover_image"]["name"];
$fileName=basename($fileNa);

$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["edit"]) && isset($_GET['id'])){
        
        $id=$_GET['id'];
        $book_title=$_POST['book_title'];
	    $author_name=$_POST['author_name'];
	    $book_category=$_POST['book_category'];
	    $book_publisher=$_POST['book_publisher'];
	    $book_price=$_POST['book_price'];
	    $book_validity	=$_POST['book_validity'];
	    $book_description=$_POST['book_description'];
	    $cur_date=date('Y-m-d h:i:s');
	    // if image update
     if(!empty($_FILES["book_cover_image"]["name"]))
     {
         // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["book_cover_image"]["tmp_name"], $targetFilePath)){
        
           //update book
           
           $sql="update  books_master SET book_title='$book_title',author_name='$author_name',book_category='$book_category', book_publisher='$book_publisher',book_price='$book_price',book_validity='$book_validity',book_description='$book_description',book_cover_image='$fileName',updated_date='$cur_date' where id='$id'";
            $update=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
            if($update){
                //$statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $statusMsg = "Book Update   successfully !";
                
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
         $sql1="update  books_master SET book_title='$book_title',author_name='$author_name',book_category='$book_category', book_publisher='$book_publisher',book_price='$book_price',book_validity='$book_validity',book_description='$book_description',updated_date='$cur_date' where id='$id'";
            $update1=mysqli_query($mysqli,$sql1) or die(mysqli_error($mysqli));
            if($update1){
                //$statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $statusMsg = "Book Update   successfully !";
                
            }
            else
            {
                $statusMsg = "Book is not Update   successfully !";
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
$sqli="SELECT * from books_master where id='$id'";
$data=mysqli_query($mysqli,$sqli);
$row=mysqli_fetch_assoc($data);

$p_cat=$row['book_category'];


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
              <div class="page_title">Edit Book</div>
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
                  <label class="col-sm-2 control-label">Book Title:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control " name="book_title"  value="<?php echo $row['book_title']; ?>" required="required">
                  </div>
                  <label class="col-sm-2 control-label">Author Name :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="author_name"  value="<?php echo $row['author_name']; ?>" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Book Category:</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="book_category" required="required">
                    <option value selected disabled>Please Select Category</option>
                    <option value="Art" <?php if($p_cat=='Art') echo 'selected';?>>Art</option>
                    <option value="Food" <?php if($p_cat=='Food') echo 'selected';?>>Food</option>
                    <option value="Education" <?php if($p_cat=='Education') echo 'selected';?>>Education</option>
                    <option value="Technology" <?php if($p_cat=='Technology') echo 'selected';?>>Technology</option>
                    
                    </select>
                  </div>
                  <label class="col-sm-2 control-label">Book Publisher :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="book_publisher"  value="<?php echo $row['book_publisher']; ?>" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Book Price:</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control " name="book_price"  value="<?php echo $row['book_price']; ?>" required="required">
                  </div>
                  <label class="col-sm-2 control-label">Book Validity :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="book_validity"  value="<?php echo $row['book_validity']; ?>" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Book Description:</label>
                  <div class="col-sm-4">
                    <textarea class="form-control " name="book_description" required="required"><?php echo $row['book_description'];?></textarea>
                  </div>
                  <label class="col-sm-1 control-label">Book Cover Image :</label>
               
                     <div class="col-sm-2">
                         <div class="block_wallpaper add_wall_category">           
                            <!--<div class="wall_image_title">-->
                            <!-- <ul>                -->
                            <!--  <li>-->
                            <!--     <a href="id=<?php //echo $row['id'];?>" data-toggle="tooltip" data-tooltip="Remove" onclick="return confirm('Are you sure you want to Remove this Image?');"><i class="fa fa-trash"></i></a>-->
                            <!--  </li>-->
                            <!--</ul>-->
                            <!--</div>-->
                              <span><img src="upload_books/cover/<?php echo $row['book_cover_image'];?>" alt="" style="height:50px;" /></span>
                            </div>
                         
        				<!--<img src="upload_books/cover/<?php //echo $row['book_cover_image'];?>" alt="" style="height:80px;">-->
        				<!--<button type="button" name="closed" class="btn btn-xs btn-danger" aria-label="Close">-->
        				<!--	<i class="fa fa-trash" aria-hidden="true"></i> Remove -->
        				<!--</button>-->
                    </div>
   
                  <div class="col-sm-3">
                    <input type="file" class="form-control" name="book_cover_image">
                  </div>
                </div>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-1">
                      <button type="submit" name="edit" class="btn btn-sm btn-primary">Save</button>
                      <button type="reset"  class="btn btn-sm btn-danger">Reset</button>
                      <a href="books_master.php" class="btn btn-sm btn-success">Back</a>
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
