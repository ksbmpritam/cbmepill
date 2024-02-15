<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  //'filters' => array(array('Area' => '=', 'value' => 'ALL')),

     
  $data_qry="SELECT * FROM tbl_video ORDER BY id DESC";
  $data_result=mysqli_query($mysqli,$data_qry); 
 
 if(isset($_REQUEST['edit']))
 {
     $id=base64_decode($_REQUEST['edit']);
     $slider="SELECT * FROM slider_image where id='$id'";
     $slider_result1=mysqli_query($mysqli,$slider); 
     $s_result=mysqli_fetch_assoc($slider_result1);
 }
 
 if(isset($_POST['update']))
  {
      if($_FILES['big_picture']['name']!="")
      {
        $icon=$_FILES['big_picture']['name'];
        $temp=$_FILES['big_picture']['tmp_name'];
        move_uploaded_file($temp,"images/".$icon);  
      }
      else
      {
          $icon=$s_result['image'];
      }
      if($_POST['cat_id']=='')
      {
          $_POST['cat_id']=0;
      }
      $id=base64_decode($_REQUEST['edit']);
      $qry='Update `slider_image` set  `image_name`="'.$_POST["name"].'",`image`="'.$icon.'",`type`="'.$_POST["type"].'",`category`="'.$_POST["cat_id"].'",`url`="'.$_POST["url"].'" where id="'.$id.'"';
      $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
          $_SESSION['msg']="11";
      } 
  }
  
  if(isset($_POST['submit']))
  {
      $icon=$_FILES['big_picture']['name'];
      $temp=$_FILES['big_picture']['tmp_name'];
      move_uploaded_file($temp,"images/".$icon);
      
      if($_POST['cat_id']=='')
      {
          $_POST['cat_id']=0;
      }
      $qry='INSERT INTO `slider_image`( `image_name`, `image`,`type`,`category`,`url`) VALUES ("'.$_POST['name'].'","'.$icon.'","'.$_POST['type'].'","'.$_POST['cat_id'].'","'.$_POST['url'].'")';
      $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
          $_SESSION['msg']="10";
      }
  }
  
  
   

?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Top Banner</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="page_title pull-right"><button type="submit" name="submit" class="btn btn-primary" onclick="window.location.href='topbannerlist.php'">Top Banner List</button></div>
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
            <form  name="addeditcategory" method="POST" class="form form-horizontal" enctype="multipart/form-data">
              <div class="section">
                <div class="section-body">

                  <div class="form-group">
                    <label class="col-md-3 control-label">Image Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="name" id="title" class="form-control" value="<?=$s_result['image_name']?>" placeholder="" >
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label">Select Link Type :-</label>
                    <div class="col-md-6">
                      <select name="type" id="purpose" class="select2" required>
                        <option value="">--Select Category--</option>
          				<option value="Category" <?php if($s_result['type']=='Category'){ echo 'selected';}?>>Category</option>
          				<option value="Link" <?php if($s_result['type']=='Link'){ echo 'selected';}?>>Link</option>
                      </select>
                    </div>
                  </div>
                  
               
                  
                  <div class="form-group" id="business1">
                    <label class="col-md-3 control-label">Category :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" >
                        <option value="">--Select Category--</option>
          				<?php
          				$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
	                    $cat_result=mysqli_query($mysqli,$cat_qry); 
          				while($cat_row=mysqli_fetch_array($cat_result))
          									{?>
          				<option value="<?=$cat_row['cid']?>" <?php if($s_result['category']==$cat_row['cid']){ echo 'selected';}?>><?=$cat_row['category_name']?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group" id="business2">
                    <label class="col-md-3 control-label">Enter Url :-</label>
                    <div class="col-md-6">
                      <input type="url" name="url" id="title" class="form-control" value="" placeholder="" >
                    </div>
                  </div>
                  
                  <?php if(isset($_REQUEST['edit'])){?>
                  <div class="form-gorup">
                      <label class="col-md-3 control-label">Image </label>
                      <div class="col-md-9">
                      <img src="images/<?=$s_result['image']?>" style="width:100px;margin-bottom: 20px;">
                      </div>
                  </div>
                  <?php }?>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                    <div class="col-md-6">
                      <div class="fileupload_block">
                         <input type="file" name="big_picture" value="" id="fileupload" <?php if(isset($_REQUEST['edit'])){echo "";}else{echo "required";}?>>
                         <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>    
                      </div>
                    </div>
                  </div><!--
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
                      <button type="submit" name="<?php if(isset($_REQUEST['edit'])){ echo "update";} else{echo "submit";}?>" class="btn btn-primary">
                          <?php if(isset($_REQUEST['edit'])){ echo "UPDATE";} else{echo "SUBMIT";}?></button>
                          
                          <!--<input type="submit" name="submit" value="add">-->
                          
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>                 
<script>
    $(document).ready(function(){
        $("#business1").hide();
        $("#business2").hide();
    $('#purpose').on('change', function() {
      if ( this.value == 'Category')
      //.....................^.......
      {
        $("#business1").show();
        $("#business2").hide();
      }
      else
      {
        $("#business1").hide();
        
         $("#business2").show();
      }
    });
});
</script>          
<?php include("includes/footer.php");?>       
