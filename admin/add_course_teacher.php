<?php
include("includes/header_teacher.php");

require("includes/function.php");
require("language/language.php");

$teacherId = $_SESSION['teacher_id'] ?? 58;

$cat_qry = "SELECT * FROM tbl_category ORDER BY category_name";
$cat_result = mysqli_query($mysqli, $cat_qry);

$tpath1 = 'images/';

if (isset($_POST['submit'])) {
  if (!empty($_POST['sub_category_image'])) {


    $img_res = upload_img($tpath1, $_POST['sub_category_image']);
    if (!$img_res['error']) {
      $sub_category_image = $img_res['name'];
    }
  }
  date_default_timezone_set('Asia/Kolkata');
  $today = date('d-m-Y H:i');

  $qry = "insert into sub_categories(name,new_line,`desc`,sub_category_image,date,category_id ,order_sc,teacher_id,access_code,status) values('" . $_POST['title'] . "','".$_POST['new_line']."','" . $_POST['description'] . "','" . $sub_category_image . "','" . $today . "','" . $_POST['cat_id'] . "','0','".$teacherId."','".$_POST['access_code']."','".$_POST['status']."')";
  
  $qry_result = mysqli_query($mysqli, $qry);
  $last_event_id = mysqli_insert_id($mysqli);
 
 $_SESSION['msg'] = "Add Sub Category";
    
    
  header("Location:all_cources_teacher.php");
  exit;
}
?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title">Add Sub Category</div>
        </div>
        <div class="col-md-7 col-xs-12">
            <div class="search_list">
                <div class="add_btn_primary"> <a href="all_cources_teacher.php">Sub categories</a> </div>
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row mrg-top">
        <div class="col-md-12">

          <div class="col-md-12 col-sm-12">
            <?php if (isset($_SESSION['msg'])) { ?>
              <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?php echo $client_lang[$_SESSION['msg']]; ?></a> </div>
            <?php
              unset($_SESSION['msg']);
            }
            ?>
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
                    while ($cat_row = mysqli_fetch_array($cat_result)) {
                    ?>
                      <option value="<?php echo $cat_row['cid']; ?>"><?php echo $cat_row['category_name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Name :-</label>
                <div class="col-md-6">
                  <input type="text" name="title" id="video_title" value="" class="form-control" required>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-3 control-label">Content Creator Person Name :-</label>
                <div class="col-md-6">
                  <input type="text" name="new_line" id="new_line" value="" class="form-control" required>
                </div>
              </div>
              
              <div class="form-group">

                <label class="col-md-3 control-label"> Access Code :-</label>

                <div class="col-md-6">
                    <input type="text" name="access_code" id="access_code" value="" onkeypress="return isNumber(event)" class="form-control">
                </div>

              </div>
              
              <div class="form-group">

                <label class="col-md-3 control-label"> Status :-</label>

                <div class="col-md-6">
                    <select name="status" id="status" class="select2" required>
                        <option value="">--Select Category--</option>
                        <option value="1">Active</option>
                        <option value="0">Block</option>
                  </select> 
                </div>

              </div>

              <div class="form-group" style="margin-top: 20px;width: 100%; display: inline-block;">
                <div class="col-md-3">
                  <label class="control-label">Image</label><br>

                </div>
                <div class="col-md-3">
                  <?php $src =  $row['category_image'] ? 'images/' . $row['category_image'] : 'assets/images/no+image.png' ?>
                  <label class="labeled thumbnail" data-toggle="tooltip" title="" data-original-title="Upload product image">
                    <img class="avatar" id="" src="<?php echo $src; ?>" alt="avatar" width="150" height="100">
                    <input type="file" class="sr-only inputfile" name="image" accept="image/*" data-width="" data-height="">
                    <input type="hidden" name="sub_category_image" class="default imghidden">
                  </label>


                </div>

                <div class="col-md-3">
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-3 control-label"> Description :-</label>
                <div class="col-md-6">
                  <textarea name="description" id="description" class="form-control"></textarea>

                  <script>
                    CKEDITOR.replace('description');
                  </script>
                </div>
              </div><br>
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>