<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

$cid = filter($_GET['cid']);
$sc_id = filter($_GET['sc_id']);

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    
    $sql = "DELETE FROM `prescription_new` WHERE id='$id'";
    if(mysqli_query($mysqli,$sql)){
        $_SESSION['msg'] = "Deleted Success";
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        header("location:all_prescription_new.php");
    }
    
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">All Prescription</div>
                </div>
                
                <div class="col-md-7 col-xs-12">
              <div class="search_list">
                  
                  <div class="search_block">
                      <form  method="post" action="">
                  <input class="form-control input-sm" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
                  
                <div class="add_btn_primary"> <a href="add_prescription_new.php">Add Prescription</a> </div>
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
                        <table id="co_tableblog"  class="table table-bordered table-striped table-hover table-sm ">
                            <thead>
                                <tr>
                                    
                                    <th>Sr.No.</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Case</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                                <?php
                                
                                if(isset($_POST['data_search'])){
                                    $search_value = $_POST['search_value'];
                                    // $sql = "SELECT p.id,p.doctor_said,p.file,tc.category_name,sc.name FROM prescription p JOIN tbl_category tc JOIN sub_categories sc 
                                    // WHERE p.c_id=tc.cid AND p.sc_id=sc.id AND (category_name LIKE '%$search_value%' OR name LIKE '%$search_value%')";
                                    
                                    $sql = "SELECT p.id,p.kase,tc.category_name,sc.name,tc.cid,sc.id as sub_cat FROM prescription_new p JOIN tbl_category tc JOIN 
                                    sub_categories sc WHERE p.c_id=tc.cid AND p.sc_id=sc.id AND p.c_id=$cid AND p.sc_id=$sc_id";
                                }else{
                                    $sql = "SELECT p.id,p.kase,tc.category_name,sc.name,tc.cid,sc.id as sub_cat FROM prescription_new p JOIN tbl_category tc JOIN 
                                    sub_categories sc WHERE p.c_id=tc.cid AND p.sc_id=sc.id AND p.c_id=$cid AND p.sc_id=$sc_id";
                                    
                                }
                                
                                
                                $query = mysqli_query($mysqli,$sql);
                                $sno = 1;
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr id="box<?=$row['id']?>">
                                            <td><?=$sno++?></td>
                                            <td><?=$row['category_name']?></td>
                                            <td><?=$row['name']?></td>
                                            <td><?=$row['kase']?></td>
                                            <td>
                                                <a  class="add_I_id btn btn-sm btn-info btn-sm" href="edit_prescrition_new.php?id=<?=$row['id']?>">Edit</a>
                                                <a href="all_specific_prescrition_new.php?id=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" >Delete</a>
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

