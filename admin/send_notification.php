    <?php 
    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
    
 
  if(isset($_POST['submit'])){
      $notification_title = $_POST['notification_title'];
      $notification_msg = $_POST['notification_msg'];
      $notification_url = $_POST['notification_url'];
      
      $notification_picture_name = time().$_FILES['notification_picture']['name'];
      $notification_picture_tmp_name = $_FILES['notification_picture']['tmp_name'];
      
      move_uploaded_file($notification_picture_tmp_name,"notification_images/".$notification_picture_name);
      
      $image_url = url()."/notification_images/".$notification_picture_name;
      
      $data = array(
          "url" => $notification_msg,
          "short_desc" => $notification_title,
          "image" => $image_url
          );
      
      $date = time();
      $qry="INSERT INTO `notification` SET `title`='$notification_title',`discription`='$notification_msg',`url`='$notification_url',`image`='$image_url',`date`='$date'";
      
      $data_ins=mysqli_query($mysqli,$qry);
      
      $sql_notification = "SELECT device_token FROM `users`";
      
      $query_notification = mysqli_query($mysqli,$sql_notification);
      
      while($r = mysqli_fetch_assoc($query_notification)){
          sendGCM($data,$r['device_token']);
      }
      
      if($data_ins)
      {
          
          $_SESSION['msg']="Notification Send Successfully";
      }
  }
   

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Send Notification</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="page_title pull-right"><button type="submit" name="submit" class="btn btn-primary" onclick="window.location.href='notification_list.php'">Notificication List</button></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
                 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">×</span></button>
                    <?php echo $_SESSION['msg'] ; ?></a> 
                  </div>
                <?php unset($_SESSION['msg']);}?> 
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
            <form action="<?=$_SERVER['PHP_SELF']?>" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
               
              <div class="section">
                <div class="section-body">

                  <div class="form-group">
                    <label class="col-md-3 control-label">Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="notification_title" id="title" class="form-control" value="" placeholder="Enter Title" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Discription :-</label>
                    <div class="col-md-6">
                        <textarea name="notification_msg" id="notification_msg" class="form-control" maxlength='150' placeholder="Enter Description.." required ></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                    <div class="col-md-6">
                      <div class="fileupload_block">
                         <input type="file" name="notification_picture" id="fileupload" required>
                         <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>    
                      </div>
                    </div>
                  </div>
                 
                    <div class="form-group">
                    <label class="col-md-3 control-label">Url :-</label>
                    <div class="col-md-6">
                      <input type="url" name="notification_url" id="url" class="form-control" value="" placeholder="Enter Url Here">
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Send</button>
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

<!--script for the course and subject-->
<script>
$(document).ready(function(){
  $('#cat_id').change(function(){
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
