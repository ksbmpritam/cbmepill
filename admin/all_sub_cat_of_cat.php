<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");

$id = mysqli_real_escape_string($mysqli,$_GET['id']);

if(isset($_POST['order'])){
    $idsc = $_POST['id'];
    $order = $_POST['order_sc'];
    
    $count = count($idsc);
    for($i=0;$i<$count;$i++){
        $data = array(
            'order_sc' => $order[$i],
            );
        Update('sub_categories', $data,"WHERE id='$idsc[$i]'");
    }
    $_SESSION['msg'] = "Order Set Success";
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header("location:$actual_link");
}


if (isset($_POST['data_search'])) {

    $qry = "SELECT * FROM subject                   
                  WHERE subject.sub_categories like '%" . addslashes($_POST['search_value']) . "%'
                  ORDER BY sub_categories.name";

    $result = mysqli_query($mysqli, $qry);
} else {
    
    $get_cat_sql = "SELECT category_id FROM sub_categories sc WHERE sc.id='$id'";
    $get_cat_query = mysqli_query($mysqli,$get_cat_sql);
    $get_cat_row = mysqli_fetch_assoc($get_cat_query);
    
    $cat_id_get = $get_cat_row['category_id'];
    
    $qry = "SELECT * FROM sub_categories sc WHERE sc.category_id='$cat_id_get' ORDER BY order_sc";

    $result = mysqli_query($mysqli, $qry);
}


function get_total_item($cat_id)
{
    global $mysqli;

    $qry_songs = "SELECT COUNT(*) as num FROM event WHERE cat_id='" . $cat_id . "'";

    $total_songs = mysqli_fetch_array(mysqli_query($mysqli, $qry_songs));
    $total_songs = $total_songs['num'];

    return $total_songs;
}

//Active and Deactive status
if (isset($_GET['status_deactive_id'])) {
    $data = array('status'  =>  '0');

    $edit_status = Update('cource', $data, "WHERE cource_id = '" . $_GET['status_deactive_id'] . "'");

    $_SESSION['msg'] = "14";
    header("Location:all_cources.php");
    exit;
}
if (isset($_GET['status_active_id'])) {
    $data = array('status'  =>  '1');

    $edit_status = Update('cource', $data, "WHERE cource_id = '" . $_GET['status_active_id'] . "'");

    $_SESSION['msg'] = "13";
    header("Location:all_cources.php");
    exit;
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">Manage sub categories</div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        
                        <!--<div class="search_block">-->
                        <!--    <form method="post" action="">-->
                        <!--        <input class="form-control input-sm" placeholder="Search category..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>-->
                        <!--        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>-->
                        <!--    </form>-->
                        <!--</div>-->
                        
                        <!--<div class="add_btn_primary"> <a href="add_course.php?add=yes">Add Sub categories</a> </div>-->
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
                        <?php unset($_SESSION['msg']);
                        } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mrg-top">
                <form method="POST">
                    <button type="submit" name="order" class="btn btn-primary ml-auto">Order Set</button>
                    <div class="row">
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="col-lg-3 col-sm-6 col-xs-12">
                            <div class="block_wallpaper add_wall_category">
                                <div class="wall_image_title">
                                    <h2><a href="javascript:void(0)"><?php echo $row['name']; ?> <span>(<?php echo $row['name']; ?>)</span></a></h2>
                                    <ul>
                                        <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['id']; ?>"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="cource_edit.php?cource_id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>

                                        <li><a href="?id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-tooltip="Delete" onclick="return confirm('Are you sure you want to delete this category?');"><i class="fa fa-trash"></i></a></li>

                                        <!--<?php if ($row['status'] != "0") { ?>
                      <li><div class="row toggle_btn"><a href="all_cources.php?status_deactive_id=<?php echo $row['cource_id']; ?>" data-toggle="tooltip" data-tooltip="ENABLE">
                          <img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php } else { ?>
                      
                      <li><div class="row toggle_btn"><a href="all_cources.php?status_active_id=<?php echo $row['cource_id']; ?>" data-toggle="tooltip" data-tooltip="DISABLE">
                          <img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>
                  
                      <?php } ?>-->


                                    </ul>
                                </div>
                                <span><img src="images/<?php echo $row['sub_category_image']; ?>" /></span>
                            </div>
                            
                            <input type="hidden" name="id[]" value="<?=$row['id']?>" >
                            <input type="number" name="order_sc[]" value="<?=$row['order_sc']?>" class="form-control" />
                        </div>
                    <?php

                        $i++;
                    }
                    ?>

                </div>
                </form>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>