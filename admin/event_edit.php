<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");
$event_id =$_GET['event_id'];

 

	
	if(isset($_POST['submit']))
	{   
	  if(!isset($_FILES['main_image']) || $_FILES['main_image']['error'] == UPLOAD_ERR_NO_FILE) 
     { 
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
               
                'description'  =>  $_POST['description'],
			    );	  
     }else
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
     }
     
 	 		

	
	$gallary    = count($_FILES['gallary']['name']);
	for($i=0;$i<$gallary;$i++)
	{
		if(!empty($_FILES['gallary']['name'][$i]))
		{
			$images = rand().$_FILES['gallary']['name'][$i];
			move_uploaded_file($_FILES['gallary']['tmp_name'][$i],"images/gal/".$images) ;
			 $data2 = array(
            'event_id' => $event_id,
            'img'      => $images);
       $qry = Insert('event_gallary',$data2);
			
		}
	}

	   
$qry=Update('event', $data, "WHERE event_id = '".$event_id."'");
$_SESSION['msg']="11";
header( "Location:event_edit.php?event_id=".$event_id);
exit;	

		 
	}
	if(isset($_GET['event_gallary_id']))
	{
	    
		$cat_res=mysqli_query($mysqli,'SELECT * FROM event_gallary WHERE event_gallary_id=\''.$_GET['event_gallary_id'].'\'');
		$cat_res_row=mysqli_fetch_assoc($cat_res);


		if($cat_res_row['img']!="")
	    {
	    	unlink('images/gal'.$cat_res_row['main_image']);
			  unlink('images/thumbs/'.$cat_res_row['main_image']);

		}
 
		Delete('event_gallary','event_gallary_id='.$_GET['event_gallary_id'].'');

     
		$_SESSION['msg']="12";
header( "Location:event_edit.php?event_id=".$event_id);
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
    <?  	$event_id =  $_GET['event_id'];
    	$event_sql="SELECT * FROM event where event_id = '$event_id'";
	$event_result=mysqli_query($mysqli,$event_sql); 
	$data = mysqli_fetch_assoc($event_result);
	//echo "<pre>";print_r($data);
	
	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result=mysqli_query($mysqli,$cat_qry); 
	?>
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Edit Event</div>
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
          							<option value="<?php echo $cat_row['cid'];?>"
          							
          							<?=($cat_row['cid'] == $data['category'])?"selected":""?>
          							><?php echo $cat_row['category_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="title" id="video_title" value="<? echo $data['title'];?>" class="form-control" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Price 1 :-</label>
                    <div class="col-md-6">
                      <input type="text" name="price_1" id="video_title" value="<? echo $data['price_1'];?>" class="form-control" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Price 2 :-</label>
                    <div class="col-md-6">
                      <input type="text" name="price_2" id="video_title" value="<? echo $data['price_2'];?>" class="form-control" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Price 3 :-</label>
                    <div class="col-md-6">
                      <input type="text" name="price_3" id="video_title" value="<? echo $data['price_3'];?>" class="form-control" required>
                    </div>
                  </div>
                 
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Date From :-</label>
                    <div class="col-md-6">
                      <input type="datetime-local" name="start_date" id="video_title" value="<? echo $data['start_date'];?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Date To :-</label>
                    <div class="col-md-6">
                      <input type="datetime-local" name="end_date" id="video_title" value="<? echo $data['end_date'];?>" class="form-control" required>
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label">Location :-</label>
                    <div class="col-md-6">
                      <input type="text" name="location" id="video_title" value="<? echo $data['location'];?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Latitude :-</label>
                    <div class="col-md-6">
                      <input type="text" name="latitude" id="video_title" value="<? echo $data['latitude'];?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Longtitude :-</label>
                    <div class="col-md-6">
                      <input type="text" name="longtitude" id="video_title" value="<? echo $data['longtitude'];?>" class="form-control" required>
                    </div>
                  </div>
                     <div class="form-group">
                    <label class="col-md-3 control-label">Main Image :-</label>
                    <div class="col-md-6">
                      <input type="file" name="main_image" id="video_title" value="" class="form-control" >
                    </div>
                  </div>
                  
         <div class="form-group">
                    <label class="col-md-3 control-label">Gallary :-</label>
                    <div class="col-md-6">
                      <input type="file" name="gallary[]" id="video_title"  multiple value="" class="form-control" >
                    </div>
        </div>
       
                  <div class="form-group">
                    <label class="col-md-3 control-label">Event Description :-</label>
                    <div class="col-md-6">                    
                      <textarea name="description" id="description" class="form-control"><? echo $data['description'];?></textarea>

                      <script>CKEDITOR.replace( 'description' );</script>
                    </div>
                  </div><br>
                        <div class="form-group">
                    <label class="col-md-3 control-label">Gallary :-</label>
                    <div class="col-md-6">
                                       <div class="row">
      <?  	$event_id =  $_GET['event_id'];
    	$event_sql="SELECT * FROM event_gallary where event_id = '$event_id'";
	$event_result=mysqli_query($mysqli,$event_sql); 
	while($data = mysqli_fetch_assoc($event_result)){
	?>
    <div class="col-sm-2">
        <a href="event_edit.php?event_gallary_id=<? echo $data['event_gallary_id'];?>" >
        <img src="images/gal/<?php echo $data['img'];?>" widh="300px" alt="no">
        </a>
    </div>
    <? } ?>
    
</div> 
                    </div>
        </div>
                  
                  

                  
        
                  
                  
                  
                  
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
