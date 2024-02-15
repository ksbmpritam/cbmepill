<?php 
    include("includes/header.php");

    require("includes/function.php");
	require("language/language.php");


function update_customer_course_subjectby_userid($userid,$newcourse_id_string,$newsubjects_ids){
    
    global $mysqli;
    // start the actual SQL statement
    
$sqli="SELECT * from user where user_id='$userid'";
$data=mysqli_query($mysqli,$sqli);
$user=mysqli_fetch_assoc($data);
$res="";
if($user){    
       $courseids=$newcourse_id_string;
        
        $subjectsids=$newsubjects_ids;
$subjectsidsarray=explode(',',$newsubjects_ids);
$Type_sql="";
foreach($subjectsidsarray as $val){
$Type.='*1,2,3*';
}

$UPSQL="UPDATE `user` SET  `subid`='$subjectsids' ,".$Type_sql." `csid`='$courseids'  WHERE `user_id`='$userid' ";
  $data=mysqli_query($mysqli,$UPSQL);
      if(mysqli_affected_rows($mysqli)>0){
    	$res.="Record Update successfully";
    	}else{
    	$res.="Record Not Any update";
    	}
    
}else{
    $res="User not found in our record";
}    
return $res;
}
if(isset($_POST['update_course']) && isset($_POST['update_user_id']) && $_POST['update_user_id']!=""){
    // print_r($_POST);
     $userid=$_POST['update_user_id'];
     $newcourse_id_string=implode(',',$_POST['course_id']);
     $newsubjects_ids=implode(',',$_POST['subjects_id']);
    echo $d=update_customer_course_subjectby_userid($userid,$newcourse_id_string,$newsubjects_ids);
    $_SESSION['msg']="11";
    header( "Location:all_user.php");
    exit;

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
<!--                      <form  method="post" action="">-->
<!--                        <input class="form-control input-sm" placeholder="Search User..."  id="myInput" type="search" name="search_text" required>-->
<!--                        <button class="btn btn-info" onclick="window.location.href='excel.php'">Exccel</button> -->
<!--                       </form>  -->
<!--                    </div>-->
<!--                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!--                    <script>-->
<!--$(document).ready(function(){-->
<!--  $("#myInput").on("keyup", function() {-->
<!--    var value = $(this).val().toLowerCase();-->
<!--    $("#myTable tr").filter(function() {-->
<!--      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)-->
<!--    });-->
    
<!--  });-->
<!--});-->
<!--</script>-->
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
 




<table id="co_tableblog"  class="table table-striped table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Name</th>
            <th>mobile</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="">
    </tbody>
</table>


        </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
<?php include("includes/footer.php");?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
 
 <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>



<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body result-div">
      </div>
    </div>

  </div>
</div>

<script type="text/javascript" language="javascript" >
    $(document).ready( function () {
            var tableblog =$('#co_tableblog').DataTable({
                "lengthMenu": [ 10, 25, 50, 75, 100,250 ],
                 dom: 'Blfrtip',
                //"dom": 'Bfrtip',
                "buttons": [ 'csv' ],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    url :"<?php echo 'ajax/get_all_users.php';?>",
                    type: "post",
                 error: function(){  // error handling
                  $(".co_tableblog-error").html("");
                  }
                  }
    });
      $('#co_tableblog').on( 'click', 'a.add_I_id', function () {
        var id = $(this).attr('data_id');
        console.log(id);
         if (confirm('Are you sure you want to Add Update Course or Subject for this User?')) {
         $.ajax({
              type: "POST",
              data: {id:id},
              url :"<?php echo 'ajax/get_users_course.php';?>",
      
              success: function(result) {
               $('#myModal2').modal('show');
               $('.result-div').html(result);
              },
              async:false
            });
        } 
       });
    });    
</script>

