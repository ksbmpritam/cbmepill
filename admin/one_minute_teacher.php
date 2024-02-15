<?php
include("includes/header_teacher.php");

require("includes/function.php");
require("language/language.php");

function getCategoryName($mysqli, $category_id) {
    $category_query = mysqli_query($mysqli, "SELECT * FROM `tbl_category` WHERE cid = '$category_id'");
    $category_row = mysqli_fetch_assoc($category_query);

    return isset($category_row['category_name']) ? $category_row['category_name'] : $category_id;
}

function getSubCategoryName($mysqli, $subCategory_id) {
    $subcategory_query = mysqli_query($mysqli, "SELECT * FROM `sub_categories` WHERE id = '$subCategory_id'");
    $subcategory_row = mysqli_fetch_assoc($subcategory_query);

    return isset($subcategory_row['name']) ? $subcategory_row['name'] : '';
}

function getLessonPlanTitle($mysqli, $lesson_plan_id) {
    $lesson_plan_query = mysqli_query($mysqli, "SELECT topics FROM `lesson_plan` WHERE id = '$lesson_plan_id'");
    $lesson_plan_row = mysqli_fetch_assoc($lesson_plan_query);

    return isset($lesson_plan_row['topics']) ? $lesson_plan_row['topics'] : '';
}

function getLessonPlanContentTitle($mysqli, $lesson_plan_content_id) {
    $lesson_plan_content_query = mysqli_query($mysqli, "SELECT slo_content FROM `lesson_plan_content` WHERE id = '$lesson_plan_content_id'");
    $lesson_plan_content_row = mysqli_fetch_assoc($lesson_plan_content_query);

    return isset($lesson_plan_content_row['slo_content']) ? $lesson_plan_content_row['slo_content'] : '';
}


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM `one_minute_paper` WHERE id='$id'";
    if (mysqli_query($mysqli, $sql)) {
        $_SESSION['msg'] = "Deleted Success";
    }
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title"> All Paper </div>
                </div>

                <div class="col-md-7 col-xs-12">
                    <div class="search_list">

                        <div class="search_block">
                            <form method="post" action="">
                                <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                                <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                            </form>
                        </div>

                        <div class="add_btn_primary"> <a href="add_one_minute_paper_teacher.php"> Add Paper </a> </div>
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
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mrg-top">
                <div class="row">
                    <div class="table-responsive">
                        <table id="mytable" class="table table-bordered table-striped table-hover table-sm ">
                            <thead>
                                <tr>

                                    <th>Sr.No.</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Lesson Plan</th>
                                    <th>SLO Content</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (isset($_POST['data_search'])) {
                                    $search_value = mysqli_real_escape_string($mysqli, $_POST['search_value']);
                                    $sql = "SELECT * FROM `one_minute_paper` WHERE question LIKE '%$search_value%' ORDER BY id DESC";
                                } else {
                                    $sql = "SELECT * FROM `one_minute_paper` ORDER BY id DESC";
                                }

                                $query = mysqli_query($mysqli, $sql);
                                $sno = 1;

                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>

                                    <tr id="box<?= $row['id'] ?>">
                                        <td><?= $sno++ ?></td>
                                        <td><?= $row['title'] ?></td>
                                        <td><?= getCategoryName($mysqli, $row['category_id']); ?></td>
                                        <td><?= getSubCategoryName($mysqli, $row['sub_categories_id']) ?></td>
                                        <td><?= getLessonPlanTitle($mysqli, $row['lesson_plan_id']); ?></td>
                                        <td><?= getLessonPlanContentTitle($mysqli, $row['lesson_plan_content_id']); ?></td>
                                        <td><?php
                                        if($row['status']==1){
                                        ?>
                                        <span class="badge badge-success">Active</span>
                                        <?php }else{?>
                                            <span class="badge badge-danger">Block</span>
                                        <?php } ?>
                                        </td>
                                        <td>
                                            <a class="add_I_id btn btn-sm btn-info btn-sm" href="view_one_minute_teacher.php?id=<?= $row['id'] ?>">View</a>
                                            <a class="add_I_id btn btn-sm btn-primary btn-sm" href="edit_one_minute_teacher.php?id=<?= $row['id'] ?>">Edit</a>
                                            <a href="one_minute.php?id=<?= $row['id'] ?>" class="remove_I_id btn btn-sm btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script>
    const search = (input) => {
        let table = document.querySelector('#mytable');
        let table_row = table.querySelectorAll('tr');
        let table_column = table_row[1].querySelectorAll('td');

        for (let i = 1; i < table_row.length; i++) {
            for (let j = 0; j < table_column.length; j++) {
                let field_Value = table_row[i].querySelectorAll('td')[j];
                if (field_Value.innerText.toLowerCase().indexOf(input) > -1) {
                    table_row[i].style.display = "";
                    break;
                } else {
                    table_row[i].style.display = "none";
                }
            }
        }
    }
</script>

<!-- DataTables -->
<script src="assets/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="dist/js/demo.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
