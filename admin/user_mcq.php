<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

?>
<style>
    th{
        text-align:center;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">All MCQ</div>
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
                        <table id="co_tableblog"  class="table table-bordered table-striped table-hover table-sm text-center">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                                <?php
                                $user_id = mysqli_real_escape_string($mysqli,$_GET['user_id']);
                                
                                $sql = "SELECT tc.category_name,sc.name,tc.cid,sc.id,md.user_id FROM mcq_data md JOIN mcq m JOIN tbl_category tc JOIN sub_categories sc
                                WHERE md.mcq_id=m.id AND m.c_id=tc.cid AND m.sc_id=sc.id AND md.user_id='$user_id' GROUP BY m.sc_id";
                                $query = mysqli_query($mysqli,$sql);
                                $sno = 1;
                                
                                if(mysqli_num_rows($query) > 0){
                                    
                                    while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr>
                                            <td><?=$sno++?></td>
                                            <td><?=$row['category_name']?></td>
                                            <td><?=$row['name']?></td>
                                            <td>
                                                <a class="add_I_id btn btn-sm btn-info btn-sm" target="_blank" href="mcq_pdf_result.php?user_id=<?=$row['user_id']?>&cid=<?=$row['cid']?>&sc_id=<?=$row['id']?>">Result</a>
                                            </td>
                                        </tr>
                                    <?php
                                }
                                    
                                }else{
                                    ?>
                                        <tr>
                                            <td colspan="3">No data available</td>
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
