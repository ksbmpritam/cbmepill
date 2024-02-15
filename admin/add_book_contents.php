<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");
$statusMsg = '';
// File upload path
$targetDir = "upload_books/page/";
$fileName = basename($_FILES["page_image"]["name"]);

$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["add_new"]) && !empty($_FILES["page_image"]["name"])){

        $book_id=$_POST['book_id'];
	    $page_no=$_POST['page_no'];
	    $page_type=$_POST['page_type'];
	    
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["page_image"]["tmp_name"], $targetFilePath)){
           
            // Insert image file name into database
            $sql="INSERT INTO `book_contents` (book_id,page_no,page_type,page_image)
       VALUES('$book_id','$page_no','$page_type','$fileName')";
            // echo $sql;
            // exit;
            $insert=mysqli_query($mysqli,$sql) or die(mysqli_error($conn));
        
            if($insert){
                //$statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $statusMsg = "New Book Contents  successfully added !";
                
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
              <div class="page_title">Add Book Contents</div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
              <div class="col-md-12 col-sm-12">
                <?php if($statusMsg){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $statusMsg ; ?></div>
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
                    <input type="text" class="form-control" name="book_id" id="Book_id"  placeholder=" Enter Book ID" required="required">
                  </div>
                  <label class="col-sm-2 control-label">Book Title:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control "   id="Book_title" placeholder=" Enter Book Title" disabled="disabled" required="required">
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Page Number :</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="page_no"  placeholder=" Enter Page Number" required="required">
                  </div>
                  
                  <label class="col-sm-2 control-label">Page Type:</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="page_type" required="required">
                    <option value selected disabled>Please Select Page Type</option>
                    <option value="Paid">Paid</option>
                    <option value="Free">Free</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Book Page Image :</label>
                  <div class="col-sm-4">
                    <input type="file" class="form-control" name="page_image"   required="required">
                  </div>
                </div>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-1">
                      <button type="submit" name="add_new" class="btn btn-sm btn-primary">Save</button>
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
<script>
    $(document).ready(function(){
    $('#Book_id').on('keyup', function () {
    var book_id=$('#Book_id').val();
    //alert(book_id);
    $.ajax({
      url:"get_book_title.php",  
      method:"POST",  
      data:{book_id:book_id},  
      success:function(data)  
      {
         $('#Book_title').val(data);
      }
    
    });
    });
    });
</script>
