<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM `pill_benefits` WHERE id='$id'";
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
                    <div class="page_title">All Pill Benefits</div>
                </div>
                
                <div class="col-md-7 col-xs-12">
              <div class="search_list">
                  <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" onkeyup="search(this.value.toLowerCase())" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
                <div class="add_btn_primary"> <a href="add_pill_benefits.php">Add Pill Benefits</a> </div>
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
                                    <th>Pill</th>
                                    <th>Photo</th>
                                    <th>Benefit/Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                
                                <?php
                                
                                if(isset($_POST['data_search'])){
                                    $search_value = $_POST['search_value'];
                                    $sql = "SELECT pb.id,pb.benefits,gph.photos,p.pill,pb.type FROM pill_benefits pb JOIN game_photos gph JOIN pills p WHERE 
                                    pb.image_id=gph.id AND pb.pill_id=p.id AND (p.pill LIKE '%$search_value%' OR pb.benefits LIKE '%$search_value%')  ORDER BY pb.id DESC";
                                }else{
                                    $sql = "SELECT pb.id,pb.benefits,gph.photos,p.pill,pb.type FROM pill_benefits pb JOIN game_photos gph JOIN pills p WHERE pb.image_id=gph.id AND pb.pill_id=p.id  ORDER BY pb.id DESC";
                                }
                                
                                
                                $query = mysqli_query($mysqli,$sql);
                                $sno = 1;
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr id="box<?=$row['id']?>">
                                            <td><?=$sno++?></td>
                                            <td><?=$row['pill']?></td>
                                            <td><img src="games_photos/<?=$row['photos']?>" style="width: 180px;"></td>
                                            <td><?=$row['benefits']?></td>
                                            <td>
                                                <a  class="add_I_id btn btn-sm btn-info btn-sm" href="edit_pills_benefits.php?id=<?=$row['id']?>&image=<?=$row['photos']?>&pill=<?=$row['pill']?>&benefits=<?=$row['benefits']?>&type=<?=$row['type']?>">Edit</a>
                                                <a href="all_pill_benefits.php?id=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" >Delete</a>
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


