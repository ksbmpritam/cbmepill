<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

 
	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result=mysqli_query($mysqli,$cat_qry); 
	
	
	if(isset($_POST['submit']))
	{
	   $main_image=rand(0,99999)."_".$_FILES['main_image']['name'];
       $tpath1='images/'.$main_image;        
       $pic1=compress_image($_FILES["main_image"]["tmp_name"], $tpath1, 80);
        //Thumb Image 
     $thumbpath='images/thumbs/'.$main_image;   
     $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300'); 

        $data = array( 
			    'category'  =>  $_POST['category'],
			    'title'     =>  $_POST['title'],
			    'price_1'  =>  $_POST['price_1'],
			    'price_2'  =>  $_POST['price_2'],
			    'price_3'  =>  $_POST['price_3'],
			    
			    'start_date'  =>  $_POST['start_date'],
			    'end_date'  =>  $_POST['end_date'],
			    'location'  =>  $_POST['location'],
			    'latitude'  =>  $_POST['latitude'],
			    'longtitude'  =>  $_POST['longtitude'],
          'main_image'  =>  $main_image,

          'description'  =>  $_POST['description'],
			    );		
//print_r($data);die;
		 		$qry = Insert('event',$data);
		 		$last_event_id = mysqli_insert_id($mysqli);

	$gallary    = count($_FILES['gallary']['name']);
	for($i=0;$i<$gallary;$i++)
	{
		if(!empty($_FILES['gallary']['name'][$i]))
		{
			$images = rand().$_FILES['gallary']['name'][$i];
			move_uploaded_file($_FILES['gallary']['tmp_name'][$i],"images/gal/".$images) ;
			 $data2 = array(
            'event_id' => $last_event_id,
            'img'      => $images);
       $qry = Insert('event_gallary',$data2);
			
		}
	}
		 		 

 	    
		$_SESSION['msg']="10";
 
		header( "Location:add_event.php");
		exit;	

		 
	}
	
	  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
            $(function () {
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
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
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
            });
        </script>
<script type="text/javascript">
$(document).ready(function(e) {
           $("#video_type").change(function(){
          
           var type=$("#video_type").val();
              
              if(type=="youtube")
              { 
                //alert(type);
                $("#video_url_display").show();
                $("#video_local_display").hide();
                $("#thumbnail").hide();
              } 
              else if(type=="server_url")
              {
                 
                 $("#video_url_display").show();
                 $("#thumbnail").show();
                 $("#video_local_display").hide();
              }
              else
              {   
                     
                $("#video_url_display").hide();               
                $("#video_local_display").show();
                $("#thumbnail").show();

              }    
              
         });
        });
</script>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Event</div>
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
            <form action="" name="add_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
 
              <div class="section">
                <div class="section-body">
                   <div class="form-group">
                    <label class="col-md-3 control-label">Category :-</label>
                    <div class="col-md-6">
                      <select name="category" id="cat_id" class="select2" required>
                        <option value="">--Select Category--</option>
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
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="title" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Price 1 :-</label>
                    <div class="col-md-6">
                      <input type="text" name="price_1" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Price 2 :-</label>
                    <div class="col-md-6">
                      <input type="text" name="price_2" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Price 3 :-</label>
                    <div class="col-md-6">
                      <input type="text" name="price_3" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                 
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Date From :-</label>
                    <div class="col-md-6">
                      <input type="datetime-local" name="start_date" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Date To :-</label>
                    <div class="col-md-6">
                      <input type="datetime-local" name="end_date" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label">Location :-</label>
                    <div class="col-md-6">
                      <input type="text" name="location" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Latitude :-</label>
                    <div class="col-md-6">
                      <input type="text" name="latitude" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Longtitude :-</label>
                    <div class="col-md-6">
                      <input type="text" name="longtitude" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                     <div class="form-group">
                    <label class="col-md-3 control-label">Main Image :-</label>
                    <div class="col-md-6">
                      <input type="file" name="main_image" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                      <div class="form-group">
                    <label class="col-md-3 control-label">Gallary :-</label>
                    <div class="col-md-6">
                      <input type="file" name="gallary[]" id="video_title" value=""  multiple class="form-control" >
                    </div>
        </div>
                  
        
       
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Description :-</label>
                    <div class="col-md-6">                    
                      <textarea name="description" id="description" class="form-control"></textarea>

                      <script>CKEDITOR.replace( 'description' );</script>
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
