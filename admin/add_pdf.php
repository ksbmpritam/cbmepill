<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

      $query=mysqli_query($mysqli,"SELECT * FROM tbl_pdf where id='".$_REQUEST['cat_id']."'");
	  $row=mysqli_fetch_assoc($query);
	  
	  
	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result=mysqli_query($mysqli,$cat_qry); 
	
	if(isset($_POST['submit'])) 
	{
	  
     
     if($_FILES["pdf"]["name"]!='')
		   {
		    if(pathinfo($_FILES["pdf"]["name"], PATHINFO_EXTENSION)=='PDF' || pathinfo($_FILES["pdf"]["name"], PATHINFO_EXTENSION)=='pdf')
		    {
		     $filename=$_FILES["pdf"]["name"];
             $path="pdf/".$filename;
             $tempname=$_FILES["pdf"]["tmp_name"];
             move_uploaded_file($tempname,$path);
		   }
		   else
		   {
		   // echo "<script>alert('Please Uploade Only PDF File');window.location.href='http://padhakuji.com/video/add_pdf.php?add=yes';</script>";   
		   }    
		  }
		  else
		   {
		   $filename= $_POST['pdf_server'] ;;    
		   }
		   
		   
		 		

    date_default_timezone_set('Asia/Kolkata');
     $today = date('d/m/Y');
     
     $idnikalo=mysqli_query($mysqli,"select * from tbl_pdf where cat_id='".$_POST['cat_id']."' and subject_id='".$_POST['sub_id']."' order by `rangee` desc limit 1");
        if(mysqli_num_rows($idnikalo)>0)
        {
            $niklliid=mysqli_fetch_assoc($idnikalo);
            $idk=$niklliid['rangee']; 
            $rangee="$idk";
            $rangee++;
        }
        else
        {
            $rangee='1';
        }
          
        $data = array( 
			    'cat_id'  =>  $_POST['cat_id'],
			    'subject_id'  =>  $_POST['sub_id'],
			    'pdf_name'  =>  $_POST['pdfname'],
          'pdf'  =>  $filename,
          'featured_pdf' => $_POST['mode'],
          'date_cr'=>$today,
          'rangee'=>$rangee,
			    );
			    
			    //print_r($data);die;
			    
		 		$qry = Insert('tbl_pdf',$data);	

 	    
		$_SESSION['msg']="10";
 
		header( "Location:add_pdf.php");
		exit;	

		 
	}
	elseif(isset($_POST['edit']))
	{
	    
	  
     if($_FILES["pdf"]["name"]!='')
		   {
		    if(pathinfo($_FILES["pdf"]["name"], PATHINFO_EXTENSION)=='PDF' || pathinfo($_FILES["pdf"]["name"], PATHINFO_EXTENSION)=='pdf')
		    {
		     $filename=$_FILES["pdf"]["name"];
             $path="pdf/".$filename;
             $tempname=$_FILES["pdf"]["tmp_name"];
             move_uploaded_file($tempname,$path);
		   
		               
		    }
		   else
		   {
		    //echo "<script>alert('Please Uploade Only PDF File');window.location.href='http://padhakuji.com/video/add_pdf.php?add=yes';</script>";   
		   }    
		  }
		  else if($_POST['pdf_server'] !='' )
		  {
		    $filename = $_POST['pdf_server'];
		  }
		  else
		  {
		    $filename = $_POST['img'];
		  }
		   
		   
		   date_default_timezone_set('Asia/Kolkata');
     $today = date('d/m/Y');
		    $data = array( 
			    'cat_id'  =>  $_POST['cat_id'],
			    'subject_id'  =>  $_POST['sub_id'],
			    'pdf_name'  =>  $_POST['pdfname'],
          'pdf'  =>  $filename,
          'featured_pdf' => $_POST['mode'],
          'date_cr'=>$today,
			    ); 
			    
			    $qry=Update('tbl_pdf', $data, "WHERE id = '".$_POST['id']."'");

         
		$_SESSION['msg']="11"; 
		header( "Location:add_pdf.php?cat_id=".$_POST['id']);
		exit;		

		 
	
	}
	
	 
	  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
<script>
    $(function () {
    $('select').selectpicker();
});
</script>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add PDF</div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
            <!--<form  action="http://www.appcreator.co.in/infotrade/edit_video.php?video_id=696" method="post" class="form form-horizontal" enctype="multipart/form-data">-->
            <form   method="post" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">
                   <div class="form-group">
                    <label class="col-md-3 control-label">Course :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" >
                        <option value="">--Select Course--</option>
          							<?php
          									while($cat_row=mysqli_fetch_array($cat_result))
          									{
          							?>          						 
          							<option value="<?php echo $cat_row['cid'];?>" <?php if(isset($_REQUEST['cat_id'])){ if($row['cat_id']==$cat_row['cid']){ echo 'selected';}else{echo '';}}?>><?php echo $cat_row['category_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div> <br>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Subject :-</label>
                  <div class="col-md-6">
                       <?php if(isset($_REQUEST['cat_id'])){ ?>
                      <input type="hidden" name="id" value="<?php if(isset($_REQUEST['cat_id'])){ echo $_REQUEST['cat_id'];} ?>">
                      <input type="hidden" name="img" value="<?php if(isset($_REQUEST['cat_id'])){ echo $row['pdf'];} ?>">
                      <?php } ?>
                      <select name="sub_id" id="subj" class="select2"  >
                          <option value="<?php echo $row['subject_id'];?>"><?php if(isset($_REQUEST['cat_id'])){ echo $query=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject_name FROM subject where id='".$row['subject_id']."'"))['subject_name'];} else{ echo '--Select Subject--';}?></option>
                      </select>
                    </div>
                  </div> <br>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">PDF Name:-</label>
                    <div class="col-md-6">
                      <input type="text" name="pdfname" value="<?php if(isset($_REQUEST['cat_id'])){ echo $row['pdf_name'];}?>" class="form-control">
                    </div>
                  </div>
                  
                  <?php if(isset($_REQUEST['cat_id'])){ ?>
                  <div class="form-group">
                    <label class="col-md-3 control-label">PDF Uploade:-</label>
                    <div class="col-md-6">
                     <div class="icon"> <a href='pdf/<?=$row['pdf']?>' target='_blank'><i class=" fa fa-file-pdf-o"  aria-hidden="true" style="font-size: 40px; color:red"></i></a> </div>
                    </div>
                  </div>
                  <br>
                  <?php } ?>

<script type="text/javascript">
$(document).ready(function(e) {
 
                 $("#manualy").hide();
                $("#server").hide();
});

function select_type(e)
{
   
   // var sel = e;
    // alert(sal);
              if(e== 1)
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

  <div class="form-group">
    <label class="col-md-3 control-label">PDF Type</label>
    <div class="col-md-6">
      <select name="pdf_type" id="pdf_type"  class="form-control selectpicker" data-live-search="true"  onchange="select_type(this.value);">
         <option value=""> Select One  </option>
         <option value="1"> Manualy    </option>
         <option value="2"> From Server</option>
      </select>
    </div>
  </div>
                  <br>
                  
                  <div class="form-group" id="manualy">
                    <label class="col-md-3 control-label">PDF Uploade:-</label>
                    <div class="col-md-6">
                      <input type="file" name="pdf" class="form-control" accept=" application/pdf">
                    </div>
                  </div>

                <div class="form-group" id="server">
                    <label class="col-md-3 control-label">Select From Server:-</label>
                    <div class="col-md-6">
                       <select name="pdf_server" id=""   class="form-control selectpicker" data-live-search="true"  onchange="select_type(this.value);">
                 <?php 
  						$qry1="SELECT *  FROM `tbl_pdf`  "; 
                        $qry_result1=mysqli_query($mysqli,$qry1);
                        while($data = mysqli_fetch_assoc($qry_result1))
                        {
                  ?>   
                         <option value="<?php echo $data['pdf'];?>"><?php echo $data['pdf'];?></option>
                         <?php } ?>

                     </select>
                    </div>
                  </div>
                  
                  
                  <br>
                  <div id="thumbnail" class="form-group" style="display:none;">
                    <label class="col-md-3 control-label">Thumbnail Image:-
                      <p class="control-label-help">(Recommended resolution: 800x400)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="video_thumbnail" value="" id="fileupload">
                       <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Mode :-</label>
                    <div class="col-md-6">
                      <select class="form-control selectpicker" data-live-search="true" name="mode" >
                          <option value=""  >Select One</option>
                          <option value="0" <?=($row['featured_pdf'] == 0)?"selected":""?> >Free</option>
                          <option value="1" <?=($row['featured_pdf'] == 1)?"selected":""?> >Premium</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  
                  </div>
                  <br>
                  
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="<?php if(isset($_REQUEST['cat_id'])){ echo 'edit';}else{ echo 'submit';}?>" class="btn btn-primary">Save</button>
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
