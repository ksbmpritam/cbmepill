<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");

if (isset($_POST['order'])) {
    $id = $_POST['cid'];
    $order = $_POST['ord'];

    $count = count($id);
    for ($i = 0; $i < $count; $i++) {
        $data = array(
            'order_c' => $order[$i],
        );
        Update('tbl_category', $data, "WHERE cid='$id[$i]'");
    }
    $_SESSION['msg'] = "Order Set Success";
    header("location:manage_category.php");
}



if ( isset($_POST['data_search']) && !empty($_POST['data_search']) ) {
    
    $qry = "SELECT * FROM tbl_category WHERE tbl_category.category_name like '%" . addslashes($_POST['search_value']) . "%' ORDER BY tbl_category.category_name";

    $result = mysqli_query($mysqli, $qry);
} else {

    //Get all Category 

    $tableName = "tbl_category";
    $targetpage = "manage_category.php";
    $limit = 30;

    $query = "SELECT COUNT(*) as num FROM $tableName";
    $total_pages = mysqli_fetch_array(mysqli_query($mysqli, $query));
    $total_pages = $total_pages['num'];

    $stages = 3;
    $page = 0;
    if (isset($_GET['page'])) {
        $page = mysqli_real_escape_string($mysqli, $_GET['page']);
    }
    if ($page) {
        $start = ($page - 1) * $limit;
    } else {
        $start = 0;
    }

    $qry = "SELECT * FROM tbl_category ORDER BY tbl_category.order_c DESC LIMIT $start, $limit";

    $result = mysqli_query($mysqli, $qry);
}

if (isset($_GET['cat_id'])) {

    $cat_res = mysqli_query($mysqli, 'SELECT * FROM tbl_category WHERE cid=\'' . $_GET['cat_id'] . '\'');
    $cat_res_row = mysqli_fetch_assoc($cat_res);


    if ($cat_res_row['category_image'] != "") {
        unlink('images/' . $cat_res_row['category_image']);
        unlink('images/thumbs/' . $cat_res_row['category_image']);
    }

    Delete('tbl_category', 'cid=' . $_GET['cat_id'] . '');


    $_SESSION['msg'] = "12";
    header("Location:manage_category.php");
    exit;
}

function get_total_item($cat_id)
{
    global $mysqli;

    $qry_songs = "SELECT COUNT(*) as num FROM tbl_video WHERE cat_id='" . $cat_id . "'";

    $total_songs = mysqli_fetch_array(mysqli_query($mysqli, $qry_songs));
    $total_songs = $total_songs['num'];

    return $total_songs;
}

//Active and Deactive status
if (isset($_GET['status_deactive_id'])) {
    $data = array('status'  =>  '0');

    $edit_status = Update('tbl_category', $data, "WHERE cid = '" . $_GET['status_deactive_id'] . "'");

    $_SESSION['msg'] = "14";
    header("Location:manage_category.php");
    exit;
}
if (isset($_GET['status_active_id'])) {
    $data = array('status'  =>  '1');

    $edit_status = Update('tbl_category', $data, "WHERE cid = '" . $_GET['status_active_id'] . "'");

    $_SESSION['msg'] = "13";
    header("Location:manage_category.php");
    exit;
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-3 col-xs-12">
                    <div class="page_title">Manage Category</div>
                </div>
                <div class="col-md-9 col-xs-12">
                    <div class="search_list">
                        <div class="search_block">
                            <form method="post">
                                <input class="form-control input-sm" value="<?=$_POST['search_value']?>" onkeyup="search(this.value)" placeholder="Search Category..." aria-controls="DataTables_Table_0" type="search" name="search_value">
                                <button type="button" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="add_btn_primary"> <a href="add_category.php?add=yes">Add Category</a> </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row mrg-top">
                <div class="col-md-12">

                    <div class="col-md-12 col-sm-12">
                        <?php if (isset($_SESSION['msg'])) { ?>
                            <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <?php echo $_SESSION['msg']; ?></a> </div>
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
                            <div class="col-lg-3 col-sm-6 col-xs-12 main_div">
                                <div class="block_wallpaper add_wall_category">
                                    <div class="wall_image_title">
                                        <h2><a href="javascript:void(0)"><?php echo $row['category_name']; ?> <span>(<?php echo get_total_item($row['cid']); ?>)</span></a></h2>
                                        <ul>
                                            <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['cid']; ?>"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="add_category.php?cat_id=<?php echo $row['cid']; ?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                                            <li><a href="?cat_id=<?php echo $row['cid']; ?>" data-toggle="tooltip" data-tooltip="Delete" onclick="return confirm('Are you sure you want to delete this category?');"><i class="fa fa-trash"></i></a></li>

                                            <?php if ($row['status'] != "0") { ?>
                                                <li>
                                                    <div class="row toggle_btn"><a href="manage_category.php?status_deactive_id=<?php echo $row['cid']; ?>" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div>
                                                </li>

                                            <?php } else { ?>

                                                <li>
                                                    <div class="row toggle_btn"><a href="manage_category.php?status_active_id=<?php echo $row['cid']; ?>" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div>
                                                </li>

                                            <?php } ?>


                                        </ul>
                                    </div>
                                    <span><img src="images/<?php echo $row['category_image']; ?>" /></span>
                                </div>
                                <input type="hidden" name="cid[]" value="<?= $row['cid'] ?>">
                                <input type="number" name="ord[]" value="<?= $row['order_c'] ?>" class="form-control" />
                            </div>
                        <?php

                            $i++;
                        }
                        ?>

                    </div>

                </form>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="pagination_item_block">
                    <nav>
                        <?php if (!isset($_POST["data_search"])) {
                            include("pagination.php");
                        } ?>
                    </nav>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>
     const search = (key_word) => {
            let key = key_word.toUpperCase();
            let a = document.querySelectorAll('.main_div')

            for (var i = 0; i <= a.length; i++) {
                let b = a[i];
                b = b.querySelector('.block_wallpaper');
                b = b.querySelector('.wall_image_title');
                b = b.querySelector('h2 a')
                let data = b.innerText;
                
                if (data.toUpperCase().indexOf(key) > -1) {
                    a[i].style.display = '';
                } else {
                    a[i].style.display = 'none';
                }
                
            }
        }
</script>

<?php include("includes/footer.php"); ?>