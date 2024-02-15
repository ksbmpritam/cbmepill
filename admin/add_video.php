<?php include("includes/header.php");



	require("includes/function.php");

	require("language/language.php");



 

	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";

	$cat_result=mysqli_query($mysqli,$cat_qry); 

	

	if(isset($_POST['submit'])) 

	{

	  



		 		if ($_POST['video_type']=='Not_server_url')

                { 

                   $video_url=$_POST['video_url'];

                   /*$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);

              

                  $video_url=$file_path.$_POST['video_file_name'];*/



                   $video_thumbnail=rand(0,99999)."_".$_FILES['video_thumbnail']['name'];

       

              

                  $tpath1='images/'.$video_thumbnail;        

                  $pic1=compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);

         

               

                 $thumbpath='images/thumbs/'.$video_thumbnail;   

                 $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');

                }         



        if ($_POST['video_type']=='server_url')

        {

              $file_path = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/';

              $video_url=$file_path.$_POST['video_file_name'];



              $video_thumbnail=rand(0,99999)."_".$_FILES['video_thumbnail']['name'];

       

              

              $tpath1='images/'.$video_thumbnail;        

              $pic1=compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);

         

               

              $thumbpath='images/thumbs/'.$video_thumbnail;   

              $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');   



              $video_id='';

        } 



    date_default_timezone_set('Asia/Kolkata');

     $today = date('Y/m/d');

         $idnikalo=mysqli_query($mysqli,"select * from tbl_video where cat_id='".$_POST['cat_id']."' and subject_id='".$_POST['sub_id']."' order by `rangee` desc limit 1");

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

			    "cat_id"  =>  $_POST['cat_id'],

			    "video_type"  =>  $_POST['video_type'],

			    "video_title"  =>  $_POST['video_title'],

                "video_url"  =>  $video_url,

                "video_id"  =>  $video_id,

                "video_thumbnail"  =>  $video_thumbnail,

                "video_duration"  =>  $_POST['video_duration'],

                "video_description"  =>  $_POST['video_description'],

                "featured_video" => $_POST['mode'],

                "subject_id"=>$_POST['sub_id'],

                "date"=>$today,

                "rangee"=>$rangee,

			    );	

			    

		 		$qry = Insert('tbl_video',$data);	



 	    

		$_SESSION['msg']="10";

 

		header( "Location:add_video.php");

		exit;	



		 

	}

	

	  

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script>

$(document).ready(function(){

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

                            console.log(data);

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

                $("#videolink").prop('required',true);

              } 

              else if(type=="server_url")

              {

                 

                 $("#video_url_display").hide();               

                 $("#video_local_display").show();

                 $("#videolink").prop('required',false); 

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

              <div class="page_title">Add Item</div>

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

                      <select name="cat_id" id="cat_id" class="select2" required>

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

                    <label class="col-md-3 control-label">Sub Category :-</label>

                  <div class="col-md-6">

                      <select name="sub_id" id="subj" class="select2" required>

                          <option value="">--Select Sub Category--</option>

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

                    <label class="col-md-3 control-label">Title :-</label>

                    <div class="col-md-6">

                      <input type="text" name="video_title" id="video_title" value="" class="form-control" required>

                    </div>

                  </div>

                  <div class="form-group">

                    <label class="col-md-3 control-label">Video Description :-</label>

                    <div class="col-md-6">                    

                      <textarea name="video_description" id="video_description" class="form-control"></textarea>



                      <script>CKEDITOR.replace( 'video_description' );</script>

                    </div>

                  </div>

                  <div class="form-group">

                    <div class="col-md-9 col-md-offset-3">

                      <button type="submit" name="submit" class="btn btn-primary" style="margin-top:5px">Save</button>

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

