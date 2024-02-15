<?php
include("includes/header_teacher.php");

require("includes/function.php");
require("language/language.php");

if (isset($_GET['id'])) {
    $del = filter($_GET['id']);
    Delete('mcq', 'id=' . $del . '');

    $_SESSION['msg'] = "MCQ Deleted Success";
    header("Location:all_mcq_teacher.php");
    exit;
}

//Active and Deactive status
if (isset($_GET['status'])) {
    $userid = base64_decode($_GET['status']);
    $query = mysqli_query($mysqli, "select status from user where user_id='$userid'");
    $row = mysqli_fetch_assoc($query);
    if ($row['status'] == 0) {
        $status = 1;
    } else {
        $status = 0;
    }

    $query1 = mysqli_query($mysqli, "update user set status='$status' where user_id='$userid'");
    if ($query1) {

        $_SESSION['msg'] = "11";
        header("Location:all_user.php");
        exit;
    }
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-3 col-xs-12">
                    <div class="page_title">All MCQ</div>
                </div>
                
                <div class="col-md-3 col-xs-12">
                  <div class="search_list">
                    <!--<div class="add_btn_primary ml-3"> <a href="export_mcq.php">Export</a> </div>-->
                    <div class="add_btn_primary"> <a href="bulk_mcq_teacher.php">Bulk Upload</a> </div>
                  </div>
                </div>
                
                <!--<div class="col-md-3 col-xs-12">-->
                <!--  <div class="search_list">-->
                    
                <!--  </div>-->
                <!--</div>-->

                <div class="col-md-6 col-xs-12">
              <div class="search_list">
                  
                  <div class="search_block">
                          <form  method="post" action="">
                            <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())" placeholder="Search image..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                            <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
                    </div>
                  
                <div class="add_btn_primary"> <a href="add_mcq_teacher.php">Add MCQ</a> </div>
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
                        <table id="mytable"  class="table table-bordered table-striped table-hover table-sm ">
                            <thead>
                                <tr>
                                    
                                    <th>Sr.No.</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody >
                                
                                <?php
                                
                                if(isset($_POST['data_search'])){
                                    $search_value = $_POST['search_value'];
                                    $sql = "SELECT m.id,m.title_text,sc.name,tc.category_name FROM `mcq` m JOIN tbl_category tc JOIN sub_categories sc 
                                    WHERE m.c_id=tc.cid AND m.sc_id=sc.id AND (tc.category_name LIKE '%$search_value%' OR sc.name LIKE '%$search_value%')";
                                }else{
                                    $sql = "SELECT m.id,m.title_text,sc.name,tc.category_name FROM `mcq` m JOIN tbl_category tc JOIN sub_categories sc WHERE m.c_id=tc.cid AND m.sc_id=sc.id ORDER BY id DESC";
                                }
                                
                                $query = mysqli_query($mysqli,$sql);
                                $sno = 1;
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr>
                                            <td><?=$sno++?></td>
                                            <td><?=$row['category_name']?></td>
                                            <td><?=$row['name']?></td>
                                            <td>
                                                <a  class="add_I_id btn btn-sm btn-info btn-sm" href="edit_mcq_teacher.php?id=<?=$row['id']?>">Edit</a>
                                                <a href="all_mcq_teacher.php?id=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" >Delete</a>
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

<!-- DataTables -->
<script src="assets/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="dist/js/demo.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>



<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body result-div">
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" language="javascript" >
    // $(document).ready(function () {
    //     var tableblog = $('#co_tableblog').DataTable({
    //         "lengthMenu": [10, 25, 50, 75, 100, 250],
    //         dom: 'Blfrtip',
    //         //"dom": 'Bfrtip',
    //         "buttons": ['csv'],
    //         "processing": false,
    //         "serverSide": false,
    //         "ajax": {
    //                 url: "<?php #echo 'ajax/get_all_games.php'; ?>",
    //             type: "post",
    //             error: function () {  // error handling
    //                 $(".co_tableblog-error").html("");
    //             }
    //         }
    //     });
        
        $('#co_tableblog').on('click', 'a.add_I_id', function () {
            var id = $(this).attr('data_id');
            console.log(id);
            if (confirm('Are you sure you want to Edit This Pill?')) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "<?php echo 'ajax/get_pill.php'; ?>",

                    success: function (result) {
                        $('#myModal2').modal('show');
                        $('.result-div').html(result);
                    },
                    async: false
                });
            }
        });
    });
</script>