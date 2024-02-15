<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");

date_default_timezone_set('Asia/Kolkata');
$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
$cat_result=mysqli_query($mysqli,$cat_qry);

$statusMsg = '';
if(isset($_POST['save_pdf'])) 
{
	  $course_name=$_POST['course_name'];
	  $subject_name=$_POST['subject_name'];
	  $pdf_name=$_POST['pdf_name'];
	  $pdf_type=$_POST['pdf_type'];
	  $pdf_mode=$_POST['pdf_mode'];
	  $pdf_server_name=$_POST['pdf_server_name'];
	  
	   $updated_date=date('Y-m-d');
	  
	  if($pdf_type=='Manualy' && !empty($_FILES["pdf_manual_name"]["name"]))
	  {
	      if(pathinfo($_FILES["pdf_manual_name"]["name"], PATHINFO_EXTENSION)=='PDF' || pathinfo($_FILES["pdf_manual_name"]["name"], PATHINFO_EXTENSION)=='pdf')
		    {
		     $filename=$_FILES["pdf_manual_name"]["name"];
             $path="pdf/".$filename;
             $tempname=$_FILES["pdf_manual_name"]["tmp_name"];
             move_uploaded_file($tempname,$path);
             
                 $sql="INSERT INTO `pdf_master` (course_name,subject_name,pdf_name,pdf_type,pdf_manual_name,pdf_server_name,pdf_mode,updated_date)
                    VALUES('$course_name','$subject_name','$pdf_name','$pdf_type','$filename','testing.pdf','$pdf_mode','$updated_date')";
                 //echo $sql;
                 //exit;
                $insert=mysqli_query($mysqli,$sql) or die(mysqli_error($conn));
                if($insert){
                    
                    //echo "<script>alert('Please Uploade Only PDF File');window.location.http://parikshagyan.com/add_new_pdf.php?add=yes';</script>"; 
                    
                    $statusMsg = "PDF File ulpoad successfully!";
                    
                }else{
                    $statusMsg = "File upload failed, please try again.";
                }
		   }
		   else
		   {
		      $statusMsg='Error ! Please Uploade Only PDF File !';
		   }
	      
	  }
	  else
	  {
	      $sql="INSERT INTO `pdf_master` (course_name,subject_name,pdf_name,pdf_type,pdf_manual_name,pdf_server_name,pdf_mode,updated_date)
                    VALUES('$course_name','$subject_name','$pdf_name','$pdf_type','testing.pdf','$pdf_server_name','$pdf_mode','$updated_date')";
                //echo $sql;
                //exit;
                $insert=mysqli_query($mysqli,$sql) or die(mysqli_error($conn));
                
                //$insert=mysqli_query($conn,$sql);
                
                if($insert)
                {
                    
                    //echo "<script>alert('Please Uploade Only PDF File');window.location.http://parikshagyan.com/add_new_pdf.php?add=yes';</script>"; 
                    
                  $statusMsg = "PDF File ulpoad successfully!";
                    
                }else{
                    $statusMsg = "File upload failed, please try again.";
                }
	  }
	 
}
?>



<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add New PDF</div>
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
                    <label class="col-md-3 control-label">Course :-</label>
                    <div class="col-md-6">
                      <select name="course_name" id="cat_id" class="form-control" required>
                        <option value selected disabled>--Select Course--</option>
  							<?php
  								while($cat_row=mysqli_fetch_array($cat_result))
  								{
  						    	?>          						 
  							<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>	          							 
  							<?php
  								}
  							?>
                      </select>
                    </div>
                  </div><br>
                <div class="form-group">
                    <label class="col-md-3 control-label">Subject :-</label>
                  <div class="col-md-6">
                      <select name="subject_name" id="subj" class="form-control" required>
                          <option value selected disabled>--Select Subject--</option>
                      </select>
                    </div>
                  </div><br>
                  <div class="form-group">
                    <label class="col-md-3 control-label">PDF Name:-</label>
                    <div class="col-md-6">
                      <input type="text" name="pdf_name" value="" class="form-control" placeholder="Enter PDF Name" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">PDF Type</label>
                    <div class="col-md-6">
                      <select name="pdf_type" id="pdf_type"  class="form-control"  onchange="select_type(this.value);" required>
                         <option value selected disabled> Select One </option>
                         <option value="Manualy">Manualy</option>
                         <option value="From Server">From Server</option>
                      </select>
                    </div>
                  </div>
                   <br>
                   <div class="form-group" id="manualy">
                    <label class="col-md-3 control-label">PDF Uploade:-</label>
                    <div class="col-md-6">
                      <input type="file" name="pdf_manual_name" class="form-control" accept="application/pdf">
                    </div>
                  </div>
                   <div class="form-group" id="server">
                    <label class="col-md-3 control-label">Select From Server:-</label>
                    <div class="col-md-6">
                       <select name="pdf_server_name"  class="form-control"  onchange="select_type(this.value);">
                        <?php 
  						$qry1="SELECT pdf_manual_name FROM pdf_master"; 
                        $qry_result1=mysqli_query($mysqli,$qry1);
                        while($data = mysqli_fetch_assoc($qry_result1))
                        {
                        ?>   
                         <option value selected disabled >--Select PDF File--</option>
                         <option value="<?php echo $data['pdf_manual_name'];?>"><?php echo $data['pdf_manual_name'];?></option>
                         <?php } ?>
                     </select>
                    </div>
                  </div>
                  <br>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Mode :-</label>
                    <div class="col-md-6">
                      <select class="form-control"  name="pdf_mode" required>
                          <option value selected disabled>Select Mode</option>
                          <option value="Free" >Free</option>
                          <option value="Premium">Premium</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-1">
                      <button type="submit" name="save_pdf" class="btn btn-sm btn-primary">Save</button>
                      <button type="reset"  class="btn btn-sm btn-danger">Reset</button>
                      <a href="manage_pdf.php" class="btn btn-sm btn-success">Back</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">-->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>-->
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">-->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>-->
<!--<script>-->
<!--    $(function () {-->
<!--    $('select').selectpicker();-->
<!--});-->
<!--</script>-->
<?php include("includes/footer.php");?>   
<!-- script for the getting the subject-->
<script>
    $(document).ready(function(){
        $('#cat_id').change(function(){
            var id=$(this).val();
            //alert(id);
            $('#submit_btn').text('Loading..');
            if(id=='-1'){
                $('#subj').html('<option value="-1" disabled selected>Select Subject</option>'); 
            }else{
                $("#divLoading").addClass('show');
                $('#subj').html('<option value="-1" disabled selected>Select Subject</option>');
                $.ajax({
                    type:'post',
                    url:'adnroid/subject.php',
                    data:{id:id},
                    success:function(result){
                        $("#divLoading").removeClass('show');
                        $('#subj').append(result);
                        $("#submit_btn").text('Submit');
                        //alert(result);
                    }

                });
            }
        });
    });
    </script>
     <script type="text/javascript">
    $(document).ready(function(e) {
     
    $("#manualy").hide();
    $("#server").hide();
    });
    
    function select_type(e)
    {
       
       // var sel = e;
        // alert(sal);
      if(e=='Manualy')
      { 
        $("#manualy").show();
        $("#server").hide();
        
      } 
      else 
      {
        $("#manualy").hide();
        $("#server").show();
      }
    }
    </script> 


