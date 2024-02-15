<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

function update_customer_course_subjectby_userid($userid, $newcourse_id_string, $newsubjects_ids) {

    global $mysqli;
    // start the actual SQL statement

    $sqli = "SELECT * from user where user_id='$userid'";
    $data = mysqli_query($mysqli, $sqli);
    $user = mysqli_fetch_assoc($data);
    $res = "";
    if ($user) {
        $courseids = $newcourse_id_string;

        $subjectsids = $newsubjects_ids;
        $subjectsidsarray = explode(',', $newsubjects_ids);
        $Type_sql = "";
        foreach ($subjectsidsarray as $val) {
            $Type .= '*1,2,3*';
        }

        $UPSQL = "UPDATE `user` SET  `subid`='$subjectsids' ," . $Type_sql . " `csid`='$courseids' ,`paid`=IF('$courseids' != '',1,0) WHERE `user_id`='$userid' ";
        $data = mysqli_query($mysqli, $UPSQL);
        if (mysqli_affected_rows($mysqli) > 0) {
            $res .= "Record Update successfully";
        } else {
            $res .= "Record Not Any update";
        }
    } else {
        $res = "User not found in our record";
    }
    return $res;
}

if (isset($_POST['update_course']) && isset($_POST['update_user_id']) && $_POST['update_user_id'] != "") {
    // print_r($_POST);
    $userid = $_POST['update_user_id'];
    $newcourse_id_string = implode(',', $_POST['course_id']);
    $newsubjects_ids = implode(',', $_POST['subjects_id']);
    echo $d = update_customer_course_subjectby_userid($userid, $newcourse_id_string, $newsubjects_ids);
    $_SESSION['msg'] = "11";
    header("Location:all_user.php");
    exit;
}


if (isset($_GET['user'])) {
    $del = $_GET['user'];
    Delete('users', 'id=' . $del . '');

    $_SESSION['msg'] = "12";
    header("Location:all_user.php");
    exit;
}

//Active and Deactive status
if (isset($_GET['status'])) {
    $userid = $_GET['status'];
    $query = mysqli_query($mysqli, "select status from users where id='$userid'");
    $row = mysqli_fetch_assoc($query);
    if ($row['status'] == 0) {
        $status = 1;
    } else {
        $status = 0;
    }

    $query1 = mysqli_query($mysqli, "update users set status='$status' where id='$userid'");
    if ($query1) {

        $_SESSION['msg'] = "11";
        header("Location:all_user.php");
        exit;
    }
}

if (isset($_GET['featured_active_id'])) {
    $data = array('featured_video' => '1');

    $edit_status = Update('tbl_video', $data, "WHERE id = '" . $_GET['featured_active_id'] . "'");

    $_SESSION['msg'] = "13";
    header("Location:manage_videos.php");
    exit;
}
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">All Teacher</div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <div class="search_block">
                            <form  method="post" action="">
                              <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())" placeholder="Search users..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                                    <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                              </form>
                            </div>
                             <div class="add_btn_primary"> <a href="add_users.php">Add Teacher</a> </div>
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
                        }
                        ?>	
                    </div>
                </div>
            </div>
            <div class="col-md-12 mrg-top">
                <div class="row">




                    <div class="table-responsive">
                        <table border="0" cellspacing="5" cellpadding="5">
                            <tbody><tr>
                                <td>Date</td>
                                <td><input type="date" id="date"></td>
                            </tr>
                        </tbody></table>
                        
                        <table id="mytable"  class="table table-bordered table-striped table-hover table-sm ">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Reg. Date</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                     <th>Password</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Profile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="my_body">
                                
                                <?php
                                include("../includes/connection.php");
                                
                                if(isset($_POST['data_search'])){
                                    $search_value = $_POST['search_value'];
                                    $sql = "SELECT * FROM `users` WHERE display_name LIKE '%$search_value%' OR email LIKE '%$search_value%' OR name LIKE '%$search_value%'";
                                }else{
                                    $sql = "SELECT * FROM `users` ORDER BY id DESC";
                                }
                                
                                
                                $query = mysqli_query($mysqli,$sql);
                                
                                $sno = 1;
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                    
                                        <tr>
                                            <td><?=$sno++?></td>
                                            <td><?=$row['created_at']?></td>
                                            <td><?=$row['display_name']?></td>
                                            <td><?=$row['mobile']?></td>
                                             <td><?=$row['password']?></td>
                                            <td>
                                                <?php
                                                    if($row['email']== 'null' || $row['email'] == ''){
                                                        
                                                    }else{
                                                        echo $row['email'];
                                                    }    
                                                ?>
                                            </td>
                                            <td><?=$row['gender']?></td>
                                            <td>
                                                <img src="<?=$row['profile_pic_url']?>" alt="<?=$row['display_name']?>">
                                            </td>
                                            <td>
                                                <?php 
                                                    if($row['status'] == 1){
                                                        echo "Active";
                                                    }else{
                                                        echo "Deactivate";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($row['status'] == 1){
                                                        ?>
                                                            <a href="all_user.php?status=<?=$row['id']?>" class="btn btn-sm btn-info" >Active</a>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <a href="all_user.php?status=<?=$row['id']?>" class="btn btn-sm btn-info" >Deactive</a>
                                                        <?php
                                                    }
                                                    
                                                    ?>
                                                        <a  class=" btn btn-sm btn-primary btn-sm" href="edit_users.php?id=<?=$row['id']?>">Edit</a>

                                                        <a href="all_user.php?user=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" data_id="'.$id.'"  >Delete</a>
                                                    <?php
                                                ?>
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

<script type="text/javascript" language="javascript" >
    $(document).ready(function () {
        var tableblog = $('#co_tableblog').DataTable({
            "lengthMenu": [10, 25, 50, 75, 100, 250],
            dom: 'Blfrtip',
            //"dom": 'Bfrtip',
            "buttons": ['csv'],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo 'ajax/get_all_users.php'; ?>",
                type: "post",
                error: function () {  // error handling
                    $(".co_tableblog-error").html("");
                }
            }
        });
        
        $('#co_tableblog').on('click', 'a.add_I_id', function () {
            var id = $(this).attr('data_id');
            console.log(id);
            if (confirm('Are you sure you want to Add Update Course or Subject for this User?')) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "<?php echo 'ajax/get_users_course.php'; ?>",

                    success: function (result) {
                        $('#myModal2').modal('show');
                        $('.result-div').html(result);
                    },
                    async: false
                });
            }
        });
        
        // This is written by me
        
        
        
        $("#date").change(function(){
            
            var date = $("#date").val();
            
            fetch(`user_date_filter.php?date=${date}`).
            then((res)=>{
                return res.text();
            }).then((data)=>{
                $("#my_body").html(data);
            });
            
        });
        
    });
</script>


