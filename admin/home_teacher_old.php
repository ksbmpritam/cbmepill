<?php include("includes/header_teacher.php");

$qry_cat = "SELECT COUNT(*) as num FROM tbl_category";
$total_category = mysqli_fetch_array(mysqli_query($mysqli, $qry_cat));
$total_category = $total_category['num'];


$qry_sub_cat = "SELECT COUNT(*) as num FROM sub_categories";
$qry_sub_category = mysqli_fetch_array(mysqli_query($mysqli, $qry_sub_cat));
$total_sub_category = $qry_sub_category['num'];


$qry_user = "SELECT COUNT(*) as num FROM users";
$qry_users = mysqli_fetch_array(mysqli_query($mysqli, $qry_user));
$total_user = $qry_users['num'];

?>


<div class="btn-floating" id="help-actions">
    <div class="btn-bg"></div>
    <!--button type="button" class="btn btn-default btn-toggle" data-toggle="toggle" data-target="#help-actions">
           <i class="icon fa fa-plus"></i> <span class="help-text">Shortcut</span> </button>-->
    <div class="toggle-content">
        <ul class="actions">
            <li><a href="https://www.facebook.com/MS.Group.0099" target="_blank">Website</a></li>
            <li><a href="https://codecanyon.net/user/ms_group0099" target="_blank">About</a></li>
        </ul>
    </div>
</div>


    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="#" class="card card-banner card-yellow-light">
            <div class="card-body"> <i class="icon fa fa-list-ul fa-4x"></i>
                <div class="content">
                    <div class="title">Subcategory</div>
                    <div class="value"><span class="sign"></span><?php echo $total_sub_category; ?></div>
                </div>
            </div>
        </a>
    </div>

   

</div>

<?php include("includes/footer.php"); ?>