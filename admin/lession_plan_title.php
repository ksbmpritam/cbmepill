<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

$lesson_id = 1;

if (isset($_POST['submit'])) {
    // Use prepared statements to prevent SQL injection
    $slo_content_title = mysqli_real_escape_string($mysqli, $_POST['slo_content_title']);
    $method_title = mysqli_real_escape_string($mysqli, $_POST['method_title']);
    $time_allotted_title = mysqli_real_escape_string($mysqli, $_POST['time_allotted_title']);
    $resource_provided_title = mysqli_real_escape_string($mysqli, $_POST['resource_provided_title']);


    $qry = mysqli_query($mysqli, "
        INSERT INTO lesson_plan_title (id, slo_content_title, method_title, time_allotted_title, resource_provided_title)
        VALUES ('$lesson_id', '$slo_content_title', '$method_title', '$time_allotted_title', '$resource_provided_title')
        ON DUPLICATE KEY UPDATE
        slo_content_title = VALUES(slo_content_title),
        method_title = VALUES(method_title),
        time_allotted_title = VALUES(time_allotted_title),
        resource_provided_title = VALUES(resource_provided_title)
    ");
    

    $_SESSION['msg'] = "Lesson Plan Title Updated successfully";
    header("Location: lession_plan_title.php");
    exit;
}

$event_sql = "SELECT * FROM lesson_plan_title where id = '$lesson_id'";
$event_result = mysqli_query($mysqli, $event_sql);
$data = mysqli_fetch_assoc($event_result);
?>
<link rel="stylesheet" href="assets/css/custom.css">

<style>
    .top_margin{
        margin: 15px 0!important;
    }
</style>

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="page_title_block">

                <div class="col-md-5 col-xs-12">

                    <div class="page_title">Edit Lession Plan Title</div>

                </div>
                <!--<div class="col-md-7 col-xs-12">-->
                <!--  <div class="search_list">-->
                    
                      
                <!--    <div class="add_btn_primary"> <a href="all_lession_plan.php">All Lession Plan</a> </div>-->
                <!--  </div>-->
                <!--</div>-->

            </div>

            <div class="clearfix"></div>

            <div class="row mrg-top">

                <div class="col-md-12">

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

                    <div class="col-md-12 col-sm-12">

                        <?php if (isset($_SESSION['msg'])) { ?> 

                            <div class="alert alert-success alert-dismissible" role="alert"> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                <?php echo $_SESSION['msg']; ?></a> </div>

                            <?php unset($_SESSION['msg']);
}
?> 

                    </div>

                </div>

            </div>

            <div class="card-body mrg_bottom"> 

                <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                            
                            
                            <div class="row px-2">
                                
                            
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>SLO  Content Title</label>
                                        <input type="text" class="form-control" name="slo_content_title" value="<? echo $data['slo_content_title']; ?>"  id="slo_content_title" required/>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Method Title</label>
                                        <input type="text" class="form-control" name="method_title" value="<? echo $data['method_title']; ?>" id="method_title" required/>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Time Allotted Title</label>
                                        <input type="text" class="form-control" name="time_allotted_title" value="<? echo $data['time_allotted_title']; ?>" id="time_allotted_title" required/>

                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div>
                                        <label>Resource Provided Title</label>
                                        <input type="text" class="form-control" name="resource_provided_title" value="<? echo $data['resource_provided_title']; ?>" id="resource_provided_title" required/>

                                    </div>
                                </div>
                               
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 px-2" id="submit">
                                    <div>
                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>
                                    
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<?php include("includes/footer.php"); ?>  
<script type="text/javascript" src="assets/js/pekeUpload.js"></script>
<script>

$(document).ready(function() {

    $("#file").pekeUpload(
        {
            onSubmit:true,
            limit:4,
            bootstrap:true,
            dragMode:true

        }
    );
    
});

</script>