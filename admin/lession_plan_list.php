<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");


$event_sql = "SELECT * FROM lesson_plan_title where id = 1";

$event_result = mysqli_query($mysqli, $event_sql);

$data_title = mysqli_fetch_assoc($event_result);


?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">All Lession Plan</div>
                </div>
                
                <div class="col-md-7 col-xs-12">
                  <div class="search_list">
                      
                      <div class="search_block">
                          <form  method="post" action="">
                            <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())"  placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                            <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
                    </div>
                      
                    <!--<div class="add_btn_primary"> <a href="add_lession_plan.php">Add Lession Plan</a> </div>-->
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
                                    <th> Topics</th>
                                    <th> Class</th>
                                    <th> Duration</th>
                                    <th> Subject</th>
                                    <th> Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                               <?php
                                    if (isset($_POST['data_search'])) {
                                        $search_value = $_POST['search_value'];
                                        $sql = "SELECT * FROM `lesson_plan` WHERE topics LIKE '%$search_value%'";
                                    } else {
                                        $sql = "SELECT * FROM `lesson_plan` ORDER BY id DESC";
                                    }
                                    
                                    $query = mysqli_query($mysqli, $sql);
                                    $sno = 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $user_id = $row['user_id'];
                                    
                                        $user_query = mysqli_query($mysqli, "SELECT name FROM `users` WHERE id = $user_id");
                                        $user_row = mysqli_fetch_assoc($user_query);
                                        $username = ($user_row) ? $user_row['name'] : '';
                                    
                                        ?>
                                        <tr id="box<?=$row['id']?>">
                                            <td><?=$sno++?></td>
                                            <td><?=$username?></td> 
                                            <td><?=$row['topics']?></td>
                                            <td><?=$row['class']?></td>
                                            <td><?=$row['duration']?> Minutes</td>
                                            <td><?=$row['subject']?></td>
                                            <td><?=$row['date']?></td>
                                            <td>
                                                <a class="add_I_id btn btn-sm btn-info btn-sm" href="view_lession_plan_details.php?id=<?=$row['id']?>">View</a>
                                                <!--<a href="all_lession_plan.php?id=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete ?')">Delete</a>-->
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