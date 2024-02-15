<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">All Result</div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="search_list">
                        <!--div class="add_btn_primary"> <a href="add_video.php">Add Video</a> </div>-->
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
                            <?php
                            unset($_SESSION['msg']);
                        }
                        ?>	
                    </div>
                </div>
            </div>
            <div class="col-md-12 mrg-top">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="co_tablebresult"  class="table table-bordered table-striped table-hover table-sm ">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>User Name</th>
                                        <th>Exam Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody >
                                </tbody>
                            </table>
                        </div>
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


<script type="text/javascript" language="javascript" >
    $(document).ready(function () {
        var tableblog = $('#co_tablebresult').DataTable({
            "lengthMenu": [10, 25, 50, 75, 100, 250],
            dom: 'Blfrtip',
            //"dom": 'Bfrtip',
            "buttons": ['csv'],
            "processing": true,
            "serverSide": true,
            "order": [[3, 'desc']],
            "ajax": {
                url: "<?php echo 'ajax/get_all_results.php'; ?>",
                type: "post",
                error: function () {  // error handling
                    $(".co_tableblog-error").html("");
                }
            }
        });
    });
</script>


