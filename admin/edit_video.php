<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

  //Get Category
	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result=mysqli_query($mysqli,$cat_qry); 

  $qry="SELECT * FROM tbl_video where id='".$_GET['video_id']."'";
  $result=mysqli_query($mysqli,$qry);
  $row=mysqli_fetch_assoc($result);
	
	if(isset($_POST['submit']))
	{
        
        if ($_POST['video_type']=='Not_server_url')
        {
            $video_url=$_POST['video_url'];
        }
        
        if ($_POST['video_type']=='server_url')
        {
            if($_POST['video_file_name']!="")
            {
                $file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/uploads/';
              
                $video_url=$file_path.$_POST['video_file_name'];

            }
            else
            {
                $video_url=$_POST['video_url'];
            }
            
            

              $video_id='';
        } 
         
         
         if($_FILES['video_thumbnail']['name']!='')
            {  
              $video_thumbnail=rand(0,99999)."_".$_FILES['video_thumbnail']['name'];
              
              //Main Image
              $tpath1='images/'.$video_thumbnail;        
              $pic1=compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
         
              //Thumb Image 
              $thumbpath='images/thumbs/'.$video_thumbnail;   
              $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');   
            
                
            }
            else
            {
              $video_thumbnail=$_POST['video_thumbnail_name'];
            } 
        date_default_timezone_set('Asia/Kolkata');
        $today = date('Y/m/d');
          
        $data = array( 
          'cat_id'  =>  $_POST['cat_id'],
          'video_type'  =>  $_POST['video_type'],
          'video_title'  =>  $_POST['video_title'],
          'video_url'  =>  $video_url,
          'video_id'  =>  $video_id,
          'video_thumbnail'  =>  $video_thumbnail,
          'video_duration'  =>  $_POST['video_duration'],
          'video_description'  =>  $_POST['video_description'],
          'subject_id'=>$_POST['sub_id'],
          'featured_video' => $_POST['mode'],
          'date'=>$today,
          );
  		 		 
  		 
        $qry=Update('tbl_video', $data, "WHERE id = '".$_POST['video_id']."'");

         
		$_SESSION['msg']="11"; 
		header( "Location:edit_video.php?video_id=".$_POST['video_id']);
		exit;	

		 
	}
	
	  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
            $(function () {
                var ajaxCall;
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var video_local = $('#video_local').val();
                    if (video_local == '') {
                        alert('Please enter file name and select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('video_local', $('#video_local')[0].files[0]);
                    $('#btn').css('display', 'none');
                     $('.msg').text('Uploading in progress...');
                     $('#cancel').css("display","block");
                    ajaxCall=$.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                         
                            $('#video_file_name').val(data);
                            $('.msg').text("File uploaded successfully!!");
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
                 $('#cancel').click(function (e) {
                     ajaxCall.abort();
                     $('#btn').css('display', 'block');
                     $('#cancel').css('display', 'none');
                     $('.msg').text('Uploading Stop');
                     });
            });
        </script>
<script type="text/javascript">
$(document).ready(function(e) {
           $("#video_type").change(function(){
          
           var type=$("#video_type").val();
              
              if(type=="Not_server_url")
              { 
                $("#video_url_display").show();
                $("#video_local_display").hide(); 
              } 
              else if(type=="server_url")
              {
                 
                 $("#video_url_display").hide();               
                 $("#video_local_display").show();
                 //$("#thumbnail").show();
              }
              /*else
              {   
                     
                $("#video_url_display").hide();               
                $("#video_local_display").show();
                $("#thumbnail").show();

              }*/    
              
         });
        });
</script>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Edit Video</div>
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
            <form action="" name="edit_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <input  type="hidden" name="video_id" value="<?php echo $_REQUEST['video_id'];?>" />

              <div class="section">
                <div class="section-body">
                   <div class="form-group">
                    <label class="col-md-3 control-label">Course :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2">
                        <option value="">--Select Category--</option>
          							<?php
          									while($cat_row=mysqli_fetch_array($cat_result))
          									{
          							?>          						 
          							<option value="<?php echo $cat_row['cid'];?>" <?php if($cat_row['cid']==$row['cat_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Subject :-</label>
                    <div class="col-md-6">
                      <select name="sub_id" id="subj" class="select2">
                        <option value="">--Select Category--</option>
          							<?php
          							       $query=mysqli_query($mysqli,"select * from subject where id='".$row['subject_id']."'");
      while($cat_row=mysqli_fetch_assoc($query)){
          							?>          						 
          							<option value="<?php echo $cat_row['id'];?>" <?php if($cat_row['id']==$row['subject_id']){?>selected<?php }?>><?php echo $cat_row['subject_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  <script>
                      $(document).ready(function(){
                         $('#cat_id').change(function(){
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
                    <label class="col-md-3 control-label">Video Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="video_title" id="video_title" value="<?php echo $row['video_title']?>" class="form-control" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Video duration :-</label>
                    <div class="col-md-6">
                      <input type="text" name="video_duration" id="video_duration" value="<?php echo $row['video_duration']?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Video Type :-</label>
                    <div class="col-md-6">                       
                      <select name="video_type" id="video_type" style="width:280px; height:25px;" class="select2" required>
                            <option value="">--Select Type--</option>                             
                            <option value="server_url" <?php if($row['video_type']=='server_url'){?>selected<?php }?>>New Uploade Video</option>
                            <option value="Not_server_url" <?php if($row['video_type']=='Not_server_url'){?> selected<?php }?>>Get From Server</option>
                      </select>
                    </div>
                  </div>
                  <div id="video_local_display" class="form-group" style="display:<?php if($row['video_type']=='server_url'){ echo 'block';}else{ echo 'none';}?>">
                    <label class="col-md-3 control-label">Video Upload :-</label>
                    <div class="col-md-6">
                    
                    <input type="hidden" name="video_file_name" id="video_file_name" value="" class="form-control">
                      <input type="file" name="video_local" id="video_local" value="" class="form-control">
                      <div><label class="control-label">Current URL :-</label><?php echo $row['video_url']?></div><br>
                      <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                        <input type="button" id="btn" class="btn btn-success" value="Upload" />
                        <input type="button" id="cancel" class="btn btn-danger" value="Cancel" style="display:none"/>
                    </div>
                  </div><br>
                  
                  
                  <div id="video_url_display" class="form-group" style="display:<?php if($row['video_type']=='Not_server_url'){ echo 'block';}else{ echo 'none';}?>">
                    <label class="col-md-3 control-label">Select Video:-</label>
                    <div class="col-md-6">
                    <select name="video_url"  class="select2" required>
                        <option value="">--Select Video--</option>
          							<?php
          							$qry1="SELECT DISTINCT(`video_title`) FROM `tbl_video`  "; 
		                            $qry_result1=mysqli_query($mysqli,$qry1);
		if(mysqli_num_rows($qry_result1)>0)
		{
		    $s=1;
		    while($row1=mysqli_fetch_assoc($qry_result1))
		    {
		         $qry2="SELECT * FROM `tbl_video`  where video_title='".$row1['video_title']."' order by id asc limit 1";
		         $qry_result2=mysqli_query($mysqli,$qry2);$row2=mysqli_fetch_assoc($qry_result2);
          							?>          						 
          							<option value="<?php echo $row2['video_url'];?>" <?php if($row2['video_title']==$row['video_title']){echo 'selected';}?>><?php echo $row2['video_title'];?></option>	          							 
          							<?php
          							}	}
          							?>
                      </select>
                    </div>
                  </div><br>
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Mode :-</label>
                    <div class="col-md-6">
                      <select class="form-control" name="mode" >
                          <option value=""  >Select One</option>
                          <option value="0" <?=($data['mode'] == 0)?"selected":""?> >Free</option>
                          <option value="1" <?=($data['mode'] == 1)?"selected":""?> >Premium</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div id="thumbnail" class="form-group" >
                    <label class="col-md-3 control-label">Thumbnail Image:-
                      <p class="control-label-help">(Recommended resolution: 800x400)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="video_thumbnail" value="" id="fileupload">
                       <?php if($row['video_thumbnail']!="") {?>
                       <input type="hidden" name="video_thumbnail_name" id="video_thumbnail_name" value="<?php echo $row['video_thumbnail'];?>" class="form-control">
                              
                          <?php }?>
                          <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp; </label>
                    <div class="col-md-6">
                      <?php if(isset($_GET['video_id']) and $row['video_thumbnail']!="") {?>
                            <div class="block_wallpaper"><img src="images/<?php echo $row['video_thumbnail'];?>" alt="image" /></div>
                          <?php } ?>
                    </div>
                  </div><br>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Video Description :-</label>
                    <div class="col-md-6">                    
                      <textarea name="video_description" id="video_description" class="form-control"><?php echo $row['video_description']?></textarea>

                      <script>CKEDITOR.replace( 'video_description' );</script>
                    </div>
                  </div><br> 
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
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
