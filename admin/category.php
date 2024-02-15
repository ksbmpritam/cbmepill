<?php include("includes/header.php");

require("includes/function.php");
require("language/language.php");





if (isset($_POST['data_search'])) {    
    $qry = "SELECT * FROM tbl_category WHERE category_name LIKE '%".$_POST['search_value']."%' ORDER BY cid DESC";
    
    $result = mysqli_query($mysqli, $qry);
} else {

    $qry = "SELECT * FROM tbl_category
                   ORDER BY cid DESC";

    $result = mysqli_query($mysqli, $qry);
}
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">Categories</div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <div class="search_block">
                            <form method="post" action="">
                                <input class="form-control input-sm" placeholder="Search category..." aria-controls="DataTables_Table_0" onkeyup="search(this.value)" type="search" name="search_value" required>
                                <button type="button" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
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
                <div class="row">
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="col-lg-3 col-sm-6 col-xs-12 main_div">
                            <div class="block_wallpaper add_wall_category">
                                <div class="wall_image_title">
                                    <h2><a href="javascript:void(0)"><?php echo $row['nacategory_nameme']; ?> <span>(<?php echo $row['category_name']; ?>)</span></a></h2>
                                    <ul>
                                        <li><a href="all_cources.php?cid=<?php echo $row['cid']; ?>" data-toggle="tooltip" data-tooltip="Sub-Category"><i class="fa fa-align-justify"></i></a></li>
                                    </ul>
                                </div>
                                <span><img src="images/<?php echo $row['category_image']; ?>" /></span>
                            </div>
                        </div>
                    <?php

                        $i++;
                    }
                    ?>

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