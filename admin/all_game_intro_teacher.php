<?php
include("includes/header_teacher.php");

require("includes/function.php");
require("language/language.php");

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM `game_intro` WHERE id='$id'";
    if(mysqli_query($mysqli,$sql)){
        $_SESSION['msg'] = "Deleted Success";
    }
    
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="card mrg_bottom">
            <div class="page_title_block">
                <div class="col-md-5 col-xs-12">
                    <div class="page_title">All Game Into</div>
                </div>
                
                <div class="col-md-7 col-xs-12">
              <div class="search_list">
                  
                  <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())"  placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
                  
                <div class="add_btn_primary"> <a href="add_game_intro_teacher.php">Add Game Into</a> </div>
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
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                                <?php
                                
                                if(isset($_POST['data_search'])){
                                    $search_value = $_POST['search_value'];
                                    
                                    $sql = "SELECT gi.id,gi.file,gi.game_case,tc.category_name,sc.name,sc.id as sub_id,tc.cid FROM game_intro gi JOIN tbl_category tc JOIN sub_categories sc 
                                    WHERE gi.c_id=tc.cid AND gi.sc_id=sc.id AND (category_name LIKE '%$search_value%' OR name LIKE '%$search_value%') GROUP BY gi.sc_id";
                                    
                                }else{
                                    $sql = "SELECT gi.id,gi.file,gi.game_case,tc.category_name,sc.name,sc.id as sub_id,tc.cid,gi.slide_id FROM game_intro gi JOIN tbl_category tc JOIN sub_categories sc WHERE gi.c_id=tc.cid AND gi.sc_id=sc.id GROUP BY gi.sc_id";
                                }
                                
                                $query = mysqli_query($mysqli,$sql);
                                $sno = 1;
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr id="box<?=$row['id']?>">
                                            <td><?=$sno++?></td>
                                            <td><?=$row['category_name']?></td>
                                            <td><?=$row['name']?></td>
                                            <td><img src="games_photos/<?=$row['file']?>" style="width: 160px;height: 100px;"></td>
                                            <td>
                                                <a  class="add_I_id btn btn-sm btn-info btn-sm" href="all_game_intro_specific_teacher.php?sub_id=<?=$row['sub_id']?>&cid=<?=$row['cid']?>">View</a>
                                                <a href="all_game_intro_teacher.php?id=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" >Delete</a>
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


