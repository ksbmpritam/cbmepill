<?php 
include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  

    
  
   if(isset($_POST['Update']))
  {
     $id=base64_decode($_REQUEST['edit']);
      $qry='update `exam` set `courseid`="'.$_POST['courseid'].'", `subjectid`="'.$_POST['subjectid'].'", `name`="'.$_POST['name'].'",`featured_mcq`="'.$_POST['mode'].'", `is_published`="'.$_POST['is_published'].'" where id="'.$id.'"';
      $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
          $_SESSION['msg']="10";
      }
      
  } 
  
  if(isset($_REQUEST['edit']))
  {
      $id=base64_decode($_REQUEST['edit']);
      $qry="select * from exam where id='$id'"; 
	  $qry_result=mysqli_query($mysqli,$qry);
	  $edit_result=mysqli_fetch_assoc($qry_result);
  }
  
  if(isset($_POST['submit']))
  {
      $getre='0';
      date_default_timezone_set('Asia/Kolkata');
      $data=date('d-m-Y');
      
      $idnikalo=mysqli_query($mysqli,"select * from exam where courseid='".$_POST['courseid']."' and subjectid='".$_POST['subjectid']."' order by `rangee` desc limit 1");
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
        
      $qry='INSERT INTO `exam`( `courseid`, `subjectid`, `name`,`DATE`,`exam_time`,`featured_mcq`,`rangee`,`is_published`) VALUES ("'.$_POST['courseid'].'","'.$_POST['subjectid'].'","'.$_POST['name'].'","'.$data.'","'.$_POST['examtime'].'","'.$_POST['mode'].'","'.$rangee.'","'.$_POST['is_published'].'")';
      $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
          $_SESSION['msg']="10";
      }
  }
  
  
   
   

?>
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
              <div class="page_title">Add Exam</div>
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
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
               
              <div class="section">
                <div class="section-body">

                  <div class="form-group">
                    <label class="col-md-3 control-label">Course :-</label>
                    <div class="col-md-6">
                      <select name="courseid" id="amrit" class="select2" required>
                        <option value="">--Select Course--</option>
          							<?php
          							    $cat_result=mysqli_query($mysqli,"SELECT * FROM `tbl_category`");
          									while($cat_row=mysqli_fetch_array($cat_result))
          									{
          							?>          						 
          							<option value="<?php echo $cat_row['cid'];?>" <?php if(isset($_REQUEST['edit'])){ if($cat_row['cid']==$edit_result['courseid']){ echo 'selected';}}?>><?php echo $cat_row['category_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Subject :-</label>
                  <div class="col-md-6">
                      <select name="subjectid" id="subj" class="select2" required>
                          <option value="<?php echo $edit_result['subjectid'];?>"><?php if(isset($_REQUEST['edit'])){ echo $query=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject_name FROM subject where id='".$edit_result['subjectid']."'"))['subject_name'];} else{ echo '--Select Subject--';}?></option>
                      </select>
                    </div>
                  </div>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                  <script>
                      $(document).ready(function(){
                         $('#amrit').change(function(){
                            var id=$(this).val();
                            $.ajax({
                                    url: "adnroid/subject.php", 
               method: "post",
               data: {id : $(this).val()} 
    })
    .done(function(response) {
        $('#subj').html(response);
                });
                         });
                      });
                  </script>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Exam Name :-</label>
                    <div class="col-md-6">
                        <input type="text" name="name" id="notification_msg" class="form-control" value="<?=$edit_result['name'];?>" required>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Exam Duration :-</label>
                    <div class="col-md-6">
                        <input type="text" name="examtime" id="notification_msg" class="form-control" placeholder="Time in minutes" value="<?=$edit_result['exam_time'];?>" required >
                    </div>
                  </div>
                  
                  <div class="form-group" style="margin-bottom: 18px;">
                    <label class="col-md-3 control-label">Mode :-</label>
                    <div class="col-md-6">
                      <select class="form-control" name="mode">
                          <option value="">Select One</option>
                          <option value="0" <?php if($edit_result['featured_mcq']=='0'){ echo 'selected';}?>>Free</option>
                          <option value="1" <?php if($edit_result['featured_mcq']=='1'){ echo 'selected';}?>>Premium</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group" style="margin-bottom: 18px;">
                    <label class="col-md-3 control-label">Publish :-</label>
                    <div class="col-md-6">
                      <select class="form-control" name="is_published">
                          <option value="0" <?php if($edit_result['is_published']=='0'){ echo 'selected';}?>>No</option>
                          <option value="1" <?php if($edit_result['is_published']=='1'){ echo 'selected';}?>>Yes</option>
                      </select>
                    </div>
                  </div>
                  <!--
                  <div class="col-md-9 mrg_bottom link_block">
                  <div class="form-group">
                    <label class="col-md-4 control-label">Video :-<br/>(Optional)
                    <p class="control-label-help">To directly open single video when click on notification</p></label>
                    <div class="col-md-8">
                      <select name="video_id" id="video_id" class="select2" required>
                        <option value="0">--Select Video--</option>
                        <?php
                            while($data_row=mysqli_fetch_array($data_result))
                            {
                        ?>                       
                        <option value="<?php echo $data_row['id'];?>"><?php echo $data_row['video_title'];?></option>                           
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div> 
                  <div class="or_link_item">
                  <h2>OR</h2>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label">External Link :-<br/>(Optional)</label>
                    <div class="col-md-8">
                      <input type="text" name="external_link" id="external_link" class="form-control" value="" placeholder="http://Ksbminfotech.com">
                    </div>
                  </div>   
                </div>  --> 
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="<?php if(isset($_REQUEST['edit'])){ echo 'Update';} else { echo 'submit';}?>" class="btn btn-primary"><?php if(isset($_REQUEST['edit'])){ echo 'Update';} else { echo 'Submit';}?></button>
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
