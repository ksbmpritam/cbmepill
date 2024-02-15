<?php
// session_start();
// print_r(phpinfo());die;

include("includes/header_teacher.php");
include("includes/session_check.php");

$teacherId = $_SESSION['teacher_id'] ?? 58;

$qry_cat = "SELECT COUNT(*) as num FROM tbl_category";
$total_category = mysqli_fetch_array(mysqli_query($mysqli, $qry_cat));
$total_category = $total_category['num'];



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

    <?php
    $qry_sub_cattt = "SELECT * FROM sub_categories WHERE teacher_id = $teacherId";
    $result = mysqli_query($mysqli, $qry_sub_cattt);
    
    if ($result) {
        while ($sub_Category_data = mysqli_fetch_assoc($result)) {
    ?>
     
        <div class="col-lg-3 col-sm-6 col-xs-12 main_div">
            <div class="block_wallpaper add_wall_category">
                <div class="wall_image_title">
                    <h2><a href="javascript:void(0)"><?php echo $sub_Category_data['name']; ?></span></a></h2>
                    <ul>
                        <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="89"><i class="fa fa-eye"></i></a></li>
                        <li><a href="access_code.php?cource_id=<?php echo $sub_Category_data['id']; ?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                    </ul>
                </div>
                <span><img src="images/<?php echo $sub_Category_data['sub_category_image']; ?>"></span>
            </div>
        </div>
    <?php
        }
    }
    ?>

   

</div>

<?php include("includes/footer.php"); ?>