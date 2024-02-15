<!-- DataTables -->
  <link rel="stylesheet" href="assets/datatables.net-bs/css/dataTables.bootstrap.min.css">
<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	 if(isset($_POST['data_search']))
   { 
              
    $data_qry="SELECT tbl_video.*,tbl_category.category_name FROM tbl_video
                  LEFT JOIN tbl_category ON tbl_video.cat_id= tbl_category.cid
                  WHERE tbl_video.video_title like '%".addslashes($_POST['search_text'])."%' 
                  ORDER BY tbl_video.video_title";
 
     $result=mysqli_query($mysqli,$data_qry); 
    
   }
   else
   {
	
      $tableName="tbl_video";   
      $targetpage = "manage_videos.php"; 
      $limit = 12; 
      
      $query = "SELECT COUNT(*) as num FROM $tableName";
      $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
      $total_pages = $total_pages['num'];
      
      $stages = 3;
      $page=0;
      if(isset($_GET['page'])){
      $page = mysqli_real_escape_string($mysqli,$_GET['page']);
      }
      if($page){
        $start = ($page - 1) * $limit; 
      }else{
        $start = 0; 
        } 
      
     $data_qry="select * from user";
 
     $result=mysqli_query($mysqli,$data_qry); 
	 
   }

  if(isset($_GET['user']))
  { 
      $del=base64_decode($_GET['user']);
   Delete('user','user_id='.$del.'');
    
    $_SESSION['msg']="12";
    header( "Location:all_user.php");
    exit;
    
  }

  //Active and Deactive status
if(isset($_GET['status']))
{
   $userid=base64_decode($_GET['status']);
   $query=mysqli_query($mysqli,"select status from user where user_id='$userid'");
   $row=mysqli_fetch_assoc($query);
   if($row['status']==0)
   {
       $status=1;
   }
   else
   {
       $status=0;
   }
   
   $query1=mysqli_query($mysqli,"update user set status='$status' where user_id='$userid'");
   if($query1)
   {
       
     $_SESSION['msg']="11";
      header( "Location:all_user.php");
      exit; 
   }
   
}

  if(isset($_GET['featured_active_id']))
  {
    $data = array('featured_video'  =>  '1');
    
    $edit_status=Update('tbl_video', $data, "WHERE id = '".$_GET['featured_active_id']."'");
    
    $_SESSION['msg']="13";
     header( "Location:manage_videos.php");
     exit;
  }

?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">All User</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" placeholder="Search User..."  id="myInput" type="search" name="search_text" required>
                        <button class="btn btn-info" onclick="window.location.href='excel.php'">Exccel</button> 
                       </form>  
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                    <script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    
  });
});
</script>
                <!--div class="add_btn_primary"> <a href="add_video.php">Add Video</a> </div>-->
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
          <div class="col-md-12 mrg-top">
            <div class="row">
 



<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped table-hover table-sm ">
    <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Name</th>
            <th>mobile</th>
            <th>Email</th>
            <th>Education Qul</th>
            <th>Stream</th>
            <th>Country</th>
            <th>State</th>
            <th>Action</th>
          
   

        </tr>
    </thead>
    <tbody id="myTable">
   
    <center>  <b></b></center>
                <?php 
            $i=1;
            while($row=mysqli_fetch_assoc($result))
            {         
        ?>
        <tr>
          <td><span class="sp"><?php echo $i;?></span></td>
          <td><span class="sp"><?php echo $row['name'].' '.$row['last_name'];?></span></td>
          <td><span class="sp"><?php echo $row['mobile'];?></span></td>
          <td><span class="sp"><?php echo $row['email'];?></span></td>
           <td><span class="sp"><?php echo $row['educ_qual'];?></span></td>
          <td><span class="sp"><?php echo $row['stream'];?></span></td>
           <td><span class="sp"><?php echo $row['country'];?></span></td>
          <td><span class="sp"><?php echo $row['state'];?></span></td>
          <td><?php if($row['status']=='1'){?><button class="btn btn-sm btn-info" onclick="window.location.href='all_user.php?status=<?=base64_encode($row['user_id']);?>'">Active</button><?php }else { ?><button class="btn btn-sm btn-warning" onclick="window.location.href='all_user.php?status=<?=base64_encode($row['user_id']);?>'">Deactive</button><?php } ?><button class="btn btn-sm btn-danger" onclick="window.location.href='all_user.php?user=<?=base64_encode($row['user_id']);?>'">Delete</button></td>
 
         	
         
		   
		            
		   
        </tr>
          <?php
            
            $i++;
              }
        ?>     
         
  </tbody>
</table>
</div>




 
       
      </div>
          </div>
           <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php if(!isset($_POST["data_search"])){ include("pagination.php");}?>     
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>  
<!-- DataTables -->
<script src="assets/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="dist/js/demo.js"></script>
<!--script for the export-->
<!--<script src="js/jquery.table2excel.js"></script>-->
<script>
  $(function () {
    $('#example').DataTable()
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
    $('#example3').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
    $('#example4').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
