<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");
$statusMsg = '';
// File upload path
$targetDir = "upload_books/cover/";
$fileName = basename($_FILES["book_cover_image"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["add_new"]) && !empty($_FILES["book_cover_image"]["name"])){

        $book_title=$_POST['book_title'];
	    $author_name=$_POST['author_name'];
	    $book_category=$_POST['book_category'];
	    $book_publisher=$_POST['book_publisher'];
	    $book_price=$_POST['book_price'];
	    $book_validity	=$_POST['book_validity'];
	    $book_description=$_POST['book_description'];
	    
	    date_default_timezone_set('Asia/Kolkata');
        $date = date('dmYhis');
        $b_first=strtoupper(substr($book_title, 0, 3));
        $b_last=strtoupper(substr($book_title, -3));
        $book_id=$b_first.'_'.$date.$b_last;

    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["book_cover_image"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database

            $sql="INSERT INTO `books_master` (book_id,book_title,author_name,book_category,book_publisher,book_price,book_validity,book_description,book_cover_image)
       VALUES('$book_id','$book_title','$author_name','$book_category','$book_publisher','$book_price','$book_validity','$book_description','$fileName')";
            // echo $query;
            // exit;
            $insert=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $statusMsg = "New Book  successfully added !";
                
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
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
              <div class="page_title">Add New Book</div>
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
                    <input type="text" class="form-control " name="book_title"  placeholder=" Enter Book Title" required="required">
                  </div>
                  <label class="col-sm-2 control-label">Author Name :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="author_name"  placeholder=" Enter Author Name" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Book Category:</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="book_category" required="required">
                    <option value selected disabled>Please Select Category</option>
                    <option value="Art">Art</option>
                    <option value="Food">Food</option>
                    <option value="Education">Education</option>
                    <option value="Technology">Technology</option>
                    
                    </select>
                  </div>
                  <label class="col-sm-2 control-label">Book Publisher :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="book_publisher"  placeholder=" Enter Publisher Name" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Book Price:</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control " name="book_price"  placeholder=" Enter Book Price" required="required">
                  </div>
                  <label class="col-sm-2 control-label">Book Validity :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="book_validity"  placeholder=" Enter Book Validity" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Book Description:</label>
                  <div class="col-sm-4">
                    <textarea class="form-control " name="book_description"  placeholder=" Enter Book Description..." required="required"></textarea>
                  </div>
                  <label class="col-sm-2 control-label">Book Cover Image :</label>
                  <div class="col-sm-4">
                    <input type="file" class="form-control" name="book_cover_image"   required="required">
                  </div>
                </div>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-1">
                      <button type="submit" name="add_new" class="btn btn-sm btn-primary">Save</button>
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
