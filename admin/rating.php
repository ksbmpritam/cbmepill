<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");



// $event_sql = "SELECT * FROM lesson_plan_title where user_id = 1";
// $event_result = mysqli_query($mysqli, $event_sql);
// $data_title = mysqli_fetch_assoc($event_result);


function getTeacher($mysqli, $teacher_id){
    $event_sql = "SELECT * FROM users WHERE id = '$teacher_id'";
    $event_result = mysqli_query($mysqli, $event_sql);
    $data_title = mysqli_fetch_assoc($event_result);
    return $data_title['name'] ?: $data_title['display_name'];
}

function getCategory($mysqli, $category_id){
    $event_sql = "SELECT * FROM tbl_category WHERE cid = '$category_id'";
    $event_result = mysqli_query($mysqli, $event_sql);
    $data_title = mysqli_fetch_assoc($event_result);
    return $data_title['category_name'];
}


function getSubCategory($mysqli, $sub_category_id){
    $event_sql = "SELECT * FROM sub_categories WHERE id = '$sub_category_id'";
    $event_result = mysqli_query($mysqli, $event_sql);
    $data_title = mysqli_fetch_assoc($event_result);
    return $data_title['name'];
}

function getLessonPlan($mysqli, $lesson_plan_id){
    $event_sql = "SELECT * FROM lesson_plan WHERE id = '$lesson_plan_id'";
    $event_result = mysqli_query($mysqli, $event_sql);
    $data_title = mysqli_fetch_assoc($event_result);
    return $data_title['topics'];
}

function getLessonPlanContent($mysqli, $lesson_plan_content_id){
    $event_sql = "SELECT * FROM lesson_plan_content WHERE id = '$lesson_plan_content_id'";
    $event_result = mysqli_query($mysqli, $event_sql);
    $data_title = mysqli_fetch_assoc($event_result);
    return $data_title['slo_content'];
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">All Rating</div>
                </div>
                
                <div class="col-md-7 col-xs-12">
                  <div class="search_list">
                      
                      <div class="search_block">
                          <form  method="post" action="">
                            <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())"  placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                            <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
                    </div>
                      
                    <!--<div class="add_btn_primary"> <a href="add_lession_plan.php">Add Lesson Plan</a> </div>-->
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
                                    <th>Teacher Name</th>
                                    <th>Student Name</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Lesson Plan</th>
                                    <th>Lesson Plan Content</th>
                                    <th>Clear</th>
                                    <th>Interesting</th>
                                    <th>Easy To Take Notes From</th>
                                    <th>Well Organised</th>
                                    <th>Relevant To The Course</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                                <?php
                                  
                                    $sql = "SELECT * FROM `rating` ORDER BY id DESC";
                                  
                                    $query = mysqli_query($mysqli, $sql);
                                    $sno = 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                        <tr id="box<?=$row['id']?>">
                                            <td><?=$sno++?></td>
                                            <td><?php echo getTeacher($mysqli,$row['teacher_id']);?></td>
                                            <td><?php echo $row['student_id'];?></td>
                                            <td><?php echo getCategory($mysqli,$row['category_id']);?></td>
                                            <td><?php echo getSubCategory($mysqli,$row['sub_categories_id']);?></td>
                                            <td><?php echo getLessonPlan($mysqli,$row['lesson_plan_id']);?></td>
                                            <td><?php echo getLessonPlanContent($mysqli,$row['lesson_plan_content_id']); ?></td>
                                            <td><?=$row['clear']?> </td>
                                            <td><?=$row['interesting']?></td>
                                            <td><?=$row['easy_to_take_notes_from']?></td>
                                            <td><?=$row['well_organised']?></td>
                                            <td><?=$row['relevant_to_the_course']?></td>
                                           
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
