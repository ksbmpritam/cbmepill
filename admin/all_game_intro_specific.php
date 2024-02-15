<?php
include("includes/header.php");

require("includes/function.php");
require("language/language.php");

$cid = $_GET['cid'];
$sub_id = $_GET['sub_id'];

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM `game_intro` WHERE id='$id'";
    if(mysqli_query($mysqli,$sql)){
        $_SESSION['msg'] = "Deleted Success";
    }
    
}



if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $order = $_POST['order'];
    
    $count = count($id);
    for($i=0;$i<$count;$i++){
        $data = array(
            'intro_order' => $order[$i],
            );
        Update('game_intro', $data,"WHERE slide_id='$id[$i]'");
    }
    $_SESSION['msg'] = "Order Set Success";
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header("location:$actual_link");
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
                <div class="add_btn_primary"> <a href="add_game_intro.php">Add Game Into</a> </div>
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
                        <form method="POST">
                        <input type="submit" class="form-control" name="submit">
                        <table id="co_tableblog"  class="table table-bordered table-striped table-hover table-sm ">
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
                                $sql = "SELECT gi.id,gi.file,gi.game_case,tc.category_name,sc.name,sc.id as sub_id,tc.cid,gi.intro_order,gi.slide_id FROM game_intro gi JOIN tbl_category tc 
                                JOIN sub_categories sc WHERE gi.c_id=tc.cid AND gi.sc_id=sc.id AND gi.c_id='$cid' AND gi.sc_id='$sub_id' GROUP BY gi.slide_id ORDER BY gi.intro_order ASC";
                                $query = mysqli_query($mysqli,$sql);
                                $sno = 1;
                                
                                while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                        <tr id="box<?=$row['id']?>">
                                            <td><?=$sno++?></td>
                                            <td><?=$row['category_name']?></td>
                                            <td><?=$row['name']?></td>
                                            
                                            <td>
                                                <?php
                                                    $ext = strtolower( end( explode(".",$row['file']) ) );
                                                    
                                                    if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif"){
                                                        ?>
                                                            <img src="games_photos/<?=$row['file']?>" style="width: 160px;height: 100px;">
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <video width="160" height="100" controls>
                                                              <source src="games_photos/<?=$row['file']?>" type="video/mp4">
                                                            </video>
                                                        <?php
                                                    }
                                                
                                                ?>
                                            </td>
                                            
                                            <td>
                                                <a  class="add_I_id btn btn-sm btn-info btn-sm" href="edit_game_intro.php?sub_id=<?=$row['sub_id']?>&cid=<?=$row['cid']?>&id=<?=$row['id']?>&slide_id=<?=$row['slide_id']?>">Edit</a>
                                                <a href="all_game_intro_specific.php?id=<?=$row['id']?>" class="remove_I_id btn btn-sm btn-danger btn-sm" >Delete</a>
                                                    
                                                    <input type="hidden" name="id[]" value="<?=$row['slide_id']?>" >
                                                    <input type="number" value="<?=$row['intro_order']?>" name="order[]" class="form-control" required>
                                                    
                                                
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


