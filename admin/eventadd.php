<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");
    
  if(isset($_REQUEST['edit']))
  {
      $id=base64_decode($_REQUEST['edit']);
      $qry="select * from newevent where id='$id'"; 
	  $qry_result=mysqli_query($mysqli,$qry);
	  $edit_result=mysqli_fetch_assoc($qry_result);
	  
  }
 
   if(isset($_POST['Update']))
  {
      $getre='0';
      $id=base64_decode($_REQUEST['edit']);
      $qry='update `newevent` set `title`="'.$_POST['title'].'", `discription`="'.$_POST['disc'].'", `date`="'.$_POST['date'].'" where id="'.$id.'"';
      $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
        
        $imagelist=mysqli_query($mysqli,"select * from neweventgallery where eventid='$id'");
        if(mysqli_num_rows($imagelist)>0)
        {
            $url='images/event/';
            while($image=mysqli_fetch_assoc($imagelist))
            {
                unlink($url.$image['image']);
            }
        }
        
        $imagedel=mysqli_query($mysqli,"delete from neweventgallery where eventid='$id'");
        
        if($imagedel)
        {
           for($i=0;$i<count($_FILES['big_picture']['name']);$i++)
        {
            $icon=$_FILES['big_picture']['name'][$i];
            $temp=$_FILES['big_picture']['tmp_name'][$i];
            move_uploaded_file($temp,"images/event/".$icon);
            $insimg=mysqli_query($mysqli,"insert into `neweventgallery`(`eventid`, `image`) VALUES ('$id','$icon')");
            $getre='1';
        } 
        }
        
        if($getre=='1')
        {
          $_SESSION['msg']="11";
        }
      }
  } 
  
  if(isset($_POST['submit']))
  {
      
      $getre='0';
      $qry='INSERT INTO `newevent`( `title`, `discription`, `date`) VALUES ("'.$_POST['title'].'","'.$_POST['disc'].'","'.$_POST['date'].'")';
      $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
        $de=mysqli_fetch_assoc(mysqli_query($mysqli,'select id from `newevent` order by id desc limit 1'))['id'];  
        for($i=0;$i<count($_FILES['big_picture']['name']);$i++)
        {
            $icon=$_FILES['big_picture']['name'][$i];
            $temp=$_FILES['big_picture']['tmp_name'][$i];
            move_uploaded_file($temp,"images/event/".$icon);
            $insimg=mysqli_query($mysqli,"INSERT INTO `neweventgallery`(`eventid`, `image`) VALUES ('$de','$icon')");
            $getre='1';
        }
        if($getre=='1')
        {
          $_SESSION['msg']="10";
        }
      }
  }
  
  
   
   

?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Event</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="page_title pull-right"><button type="submit" name="submit" class="btn btn-primary" onclick="window.location.href='neweventlist.php'">Event List</button></div>
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
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
               
              <div class="section">
                <div class="section-body">

                  <div class="form-group">
                    <label class="col-md-3 control-label">Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="title" id="title" class="form-control" value="<?=$edit_result['title'];?>" placeholder="" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Date :-</label>
                    <div class="col-md-6">
                      <input type="date" name="date" id="title" class="form-control" value="<?=$edit_result['date'];?>" placeholder="" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Discription :-</label>
                    <div class="col-md-6">
                        <textarea name="disc" id="notification_msg" class="form-control" required><?=$edit_result['discription'];?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">Image :-<br/><p class="control-label-help">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>

                    <div class="col-md-6">
                      <div class="fileupload_block">
                         <input type="file" name="big_picture[]" value="" id="fileupload" required multiple>
                         <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>    
                      </div>
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
