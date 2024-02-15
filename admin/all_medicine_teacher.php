<?php include("includes/header_teacher.php");

require("includes/function.php");
require("language/language.php");



if (isset($_REQUEST['del'])) {
    $id = $_REQUEST['del'];
    $qry = "delete from medicine_type where id='$id'";
    $qry_o = mysqli_query($mysqli, $qry);
    $_SESSION['msg'] = "Medicine Deleted Success..";
    header("location:all_medicine_teacher.php");
    die;
}




?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">Pills List</div>
                </div>

                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <div class="search_block">
                            <form method="post" action="">
                                <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                                <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        
                        <div class="add_btn_primary"> <a href="add_medicine_teacher.php">Add Pills</a> </div>
                        
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
            <div class="card-body mrg_bottom">
                <table class="table table-bordered" id="mytable">
                    <thead>
                        <tr>
                            <th>S. no</th>
                            <th>Pills</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (isset($_POST['data_search'])) {
                            $search_value = $_POST['search_value'];
                            $qry = "select * from medicine_type WHERE name LIKE '%$search_value%' order by id desc";
                        } else {
                            $qry = "select * from medicine_type order by id desc";
                        }


                        $qry_result = mysqli_query($mysqli, $qry);
                        if (mysqli_num_rows($qry_result) > 0) {
                            $s = 1;
                            while ($row = mysqli_fetch_assoc($qry_result)) {
                                $id = base64_encode($row['id']);
                        ?>
                                <tr>
                                    <td><?= $s++; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><img src="medicines/<?= $row['photo']; ?>" style="width: 100px !important;"></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="window.location.href='edit_medicine_teacher.php?id=<?= $row['id'] ?>'">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="window.location.href='all_medicine_teacher.php?del=<?= $row['id'] ?>'">Delete</button>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const search = (input) => {
        let table = document.querySelector('#mytable');
        let table_row = table.querySelectorAll('tr');
        let table_column = table_row[1].querySelectorAll('td'); //This is Total No. Of Column

        for (let i = 1; i < table_row.length; i++) {
            for(let j = 0; j < table_column.length; j++){
                let field_Value = table_row[i].querySelectorAll('td')[j]; //this is for field
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


<?php include("includes/footer.php"); ?>