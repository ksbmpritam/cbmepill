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

if (isset($_POST['update_pill']) && isset($_POST['update_pill_id']) && $_POST['update_pill_id'] != "") {
    // print_r($_POST);
    $id = $_POST['update_pill_id'];
    $pill_name = $_POST['pill'];
    $pill_code = $_POST['pill_code'];
    $pill_description = $_POST['pill_description'];
    $pill_benefits = $_POST['pill_benefits'];
    $pillType = $_POST['pillType'];
    
    $data = array(
            "pill" => $pill_name,
            "pill_code" => $pill_code,
            "pill_description" => $pill_description,
            "pill_benefits" => $pill_benefits,
            "type" => $pillType,
        );
    
    Update("pills",$data, "WHERE id='$id'");
    
    // $sql = "UPDATE `pills` SET `pill`='$pill_name' WHERE id='$id'";
    // mysqli_query($mysqli,$sql);
    
    $_SESSION['msg'] = "Pill Updated Success";
    header("Location:all_pill.php");
    exit;
}


if (isset($_GET['id'])) {
    $del = filter($_GET['id']);
    Delete('pills', 'id=' . $del . '');

    $_SESSION['msg'] = "Pill Deleted Success";
    header("Location:all_pill.php");
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
                <div class="col-md-3 col-xs-12">
                    <div class="page_title">All Pills</div>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="btn btn_warning" style="background:#f00;"> <a href="pill_export.php" style="color: #fff;">Export</a> </div>
                    <div class="btn btn-danger" style="background:#f00;"> <a onclick="delete_all()" style="color: #fff;">Delete</a> </div>
                    <div class="add_btn_primary"> <a href="add_pill.php">Add Pill</a> </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="search_block">
                      <form  method="post" action="">
                      <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())" placeholder="Search pills..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                            <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
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
                        <form method="post" id="frm">
                            
                            <table id="mytable" class="table table-bordered table-striped table-hover table-sm ">
                            <thead>
                                <tr >
                                    <th style="text-align:center;">Sr.No.</th>
                                    <th style="text-align:center;">Name</th>
                                    <th style="text-align:center;">Action</th>
                                    <th><input type="checkbox" onclick="select_all()"  id="delete"/></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                
                                <?php
                                
                                if(isset($_POST['data_search'])){
                                    $search_value = $_POST['search_value'];
                                    $sql = "SELECT * FROM `pills` WHERE pill LIKE '%$search_value%' ORDER BY id DESC ";
                                }else{
                                    $sql = "SELECT * FROM `pills` ORDER BY id DESC ";
                                }
                                
                                
                                $query = mysqli_query($mysqli,$sql);
                                
                            
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr id="box<?=$row['id']?>" style="text-align:center;">
                                            <td><?=$row['pill_code'] ?></td>
                                            <td><?=$row['pill']?></td>
                                            <td>
                                                <a class="add_I_id btn btn-sm btn-info btn-sm" href="edit_pill.php?id=<?=$row['id']?>" data_id="<?=$row['id']?>"  >Edit</a> 
                                                <a href="all_pill.php?id=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" data_id="<?=$row['id']?>">Delete</a>
                                            </td>
                                            <td>
                                                <input type="checkbox" class="checkbox" name='checkbox[]' value="<?=$row['id']?>" id="<?=$row['id']?>" />
                                            </td>
                                        </tr>
                                    <?php
                                }
                                
                                ?>
                                
                            </tbody>
                        </table>
                            
                        </form>
                        
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
    
    function select_all(){
    	if(jQuery('#delete').prop("checked")){
    		jQuery('input[type=checkbox]').each(function(){
    			jQuery('#'+this.id).prop('checked',true);
    		});
    	}else{
    		jQuery('input[type=checkbox]').each(function(){
    			jQuery('#'+this.id).prop('checked',false);
    		});
    	}
    }
    
    function delete_all(){
    	var check=confirm("Are you sure?");
    	if(check==true){
    		jQuery.ajax({
    			url:'delete_multiple_pill.php',
    			type:'post',
    			data:jQuery('#frm').serialize(),
    			success:function(result){
    				jQuery('input[type=checkbox]').each(function(){
    					if(jQuery('#'+this.id).prop("checked")){
    						jQuery('#box'+this.id).remove();
    					}
    				});
    			}
    		});
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
            "bSortable": false,
            "aTargets": [ -1 ],
            "ordering": false,
            "ajax": {
                url: "<?php echo 'ajax/get_all_pills.php'; ?>",
                type: "post",
                error: function () {  // error handling
                    $(".co_tableblog-error").html("");
                }
            }
        });
        
        $('#co_tableblogv').on('click', 'a.add_I_id', function () {
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
