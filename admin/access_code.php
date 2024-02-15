<?php

include("includes/header_teacher.php");

require("includes/function.php");

require("language/language.php");
$teacherId = $_SESSION['teacher_id'] ?? 58;
$cource_id = $_GET['cource_id'];


if (isset($_POST['submit'])) {

    $qry = mysqli_query($mysqli, "update sub_categories set access_code='" . $_POST['access_code'] . "',added_by='".$teacherId."' where id='$cource_id'");
  
  //$qry=Update('subject', $data, "WHERE id = '".$cource_id."'");

  $_SESSION['msg'] = "11";

  header("Location:home_teacher.php");

  exit;
}

$data = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM sub_categories where id = '$cource_id'"));


if($data['added_by']==$teacherId){
    $inputData="required";
}elseif($data['added_by']==''){
    $inputData="required";
}else{
    $inputData="readonly";
}


?>



<div class="row">


  <div class="col-md-12">

    <div class="card">

      <div class="page_title_block">

        <div class="col-md-5 col-xs-12">

          <div class="page_title">Edit Access Code</div>

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

                <label class="col-md-3 control-label"> Access Code :-</label>

                <div class="col-md-6">
                    <input type="text" name="access_code" id="access_code" value="<?= $data['access_code']; ?>" onkeypress="return isNumber(event)" class="form-control" <?php echo $inputData; ?>>
                </div>

              </div>
              
            
              <div class="form-group">

                <div class="col-md-9 col-md-offset-3">
            
                    <?php if ($data['added_by'] == $teacherId) { ?>
                        <button type="submit" name="submit" class="btn btn-primary">Save </button>
                    <?php } elseif ($data['added_by'] == '') { ?>
                        <button type="submit" name="submit" class="btn btn-primary btn-1">Save</button>
                    <?php } ?>
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
