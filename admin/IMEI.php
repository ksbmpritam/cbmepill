<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

    if(isset($_REQUEST['pbl']))
    {
        $id=base64_decode($_REQUEST['pbl']); 
       echo  $qry="select * from notification where id='$id'";
		$qry_o=mysqli_query($mysqli,$qry);
		$qry_fet=mysqli_fetch_assoc($qry_o);
		if($qry_fet['published']=='1')
		{
		    $published='0';
		    $quser=mysqli_query($mysqli,"select * from user");
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        $insnoti=mysqli_query($mysqli,"delete from notificationseen where `userid`='".$row['user_id']."' and `notiification`='$id'");
		    }
		}
		if($qry_fet['published']=='0')
		{
		    $published='1';
		    $quser=mysqli_query($mysqli,"select * from user");
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        $insnoti=mysqli_query($mysqli,"insert into notificationseen(`userid`, `notiification`,`published`,`paid_published`) values('".$row['user_id']."','$id','0','0')");
		    }
		}
		
		$qry="update notification set published='$published' where id='$id'";
		$qry_result=mysqli_query($mysqli,$qry);
		$_SESSION['msg']="11";
    }
    
    
    if(isset($_REQUEST['pbl1']))
    {
        $id=base64_decode($_REQUEST['pbl1']); 
       echo  $qry="select * from notification where id='$id'";
		$qry_o=mysqli_query($mysqli,$qry);
		$qry_fet=mysqli_fetch_assoc($qry_o);
		if($qry_fet['paid_published']=='1')
		{
		    $published='0';
		    $quser=mysqli_query($mysqli,"select * from user");
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        $insnoti=mysqli_query($mysqli,"delete from notificationseen where `userid`='".$row['user_id']."' and `notiification`='$id'");
		    }
		}
		if($qry_fet['paid_published']=='0')
		{
		    $published='1';
		    $quser=mysqli_query($mysqli,"select * from user");
		    while($row=mysqli_fetch_assoc($quser))
		    {
		        $insnoti=mysqli_query($mysqli,"insert into notificationseen(`userid`, `notiification`,`published`,`paid_published`) values('".$row['user_id']."','$id','0','0')");
		    }
		}
		
		$qry="update notification set paid_published='$published' where id='$id'";
		$qry_result=mysqli_query($mysqli,$qry);
		$_SESSION['msg']="11";
    }
    
    if(isset($_REQUEST['del']))
    {
       $id=base64_decode($_REQUEST['del']);
       $qry="delete from `exam` where id='$id'";
       $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
          $_SESSION['msg']="12";
      }
      }
?>
<style>
    .carousel-inner img { /* make all photos black and white */
  width: 100%; /* Set width to 100% */
  margin: auto;
}

.carousel-caption h3 {
  color: #fff !important;
}

@media (max-width: 600px) {
  .carousel-caption {
    display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
  }
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">User IMEI Manage</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="page_title pull-right"></div>
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
          <div class="card-body mrg_bottom"> 
            <input type="text" name="seach" placeholder="Search..." id="myInput" style="float:right; margin-bottom: 10px;">
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
            <table class="table table-bordered">
    <thead>
      <tr>
        <th>S. no</th>
        <th>User Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>IMEI</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody id="myTable">
        <?php 
        $qry="SELECT * FROM `user`"; 
		$qry_result=mysqli_query($mysqli,$qry);
		$numrows=mysqli_num_rows($qry_result);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $s=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
        ?>
        <form method="post">
      <tr style="" id="tr<?=$s?>">
        <td><?=$s;?></td>
        <td><?=$row['name'];?></td>
        <td><?=$row['mobile'];?></td>
        <td><?=$row['email'];?></td>
        <td><span class="token" id="token<?=$s;?>" data="<?=$s;?>"><?=$row['token'];?></span><input type="text" name="token" value="<?=$row['token'];?>" minlength="12" id="input<?=$s?>" style="border:none; display:none;" ><input type="hidden" name="user_id" value="<?=$row['user_id'];?>"></td>
        <td><input type="submit" style="padding:6px;" class="btn btn-success btn-sm" name="submit<?=$s?>" value="Update"></td>      
        </tr>
        </form>
        <?php
             if(isset($_POST['submit'.$s]))
             {
                 $query1=mysqli_query($mysqli,"update user set token='".$_POST['token']."' where user_id='".$_POST['user_id']."'");
                 if($query1)
                 {
                     echo "<script>window.location.href='http://angirasuratgarhlive.com/ksbmadmin/IMEI.php';</script>";
                     $_SESSION['msg']="11";
                 }
             }
        ?>
      <?php $s++;} }?>
    </tbody>
  </table>
 
 
     <script>
            $(document).ready(function(){
                $(".token").click(function(){
                    var one=$(this).attr('data');
                    var i=1;
                    for(i=1;i<="<?=$numrows?>";i++)
                    {
                      if(one==i)
                    {
                        $('#token'+i).css("display","none");
                        $('#input'+i).css("display","block");
                        $('#tr'+i).css("box-shadow","0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22)");
                    }
                    else
                    {
                        $('#token'+i).css("display","block");
                        $('#input'+i).css("display","none");
                        $('#tr'+i).css("box-shadow","none");
                    }    
                    }
                });
            });
        </script>
          </div>
        </div>
      </div>
    </div>
        <?php 
          $qry="select * from newevent order by id desc"; 
		$qry_result=mysqli_query($mysqli,$qry);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $sn=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
        ?>
        <div class="modal fade" id="myModal<?=$sn++;?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
         <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php 
          $query1 = "SELECT image from neweventgallery where eventid='".$row['id']."'";
          $dept1 = mysqli_query($mysqli, $query1);
          while($row1 = mysqli_fetch_assoc($dept1))
        {
            
    ?>
    <div class="item">
      <img src="images/event/<?=$row1['image'];?>" alt="New York">
    </div>
    <?php } ?>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <i class="glyphicon fa fa-chevron-left" aria-hidden="true"></i>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <i class="glyphicon fa fa-chevron-right" aria-hidden="true"></i>

    <span class="sr-only">Next</span>
  </a>
</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
        <?php  } } ?>
        
        <script>
            $(document).ready(function(){
               $('.carousel-inner .item').first().attr('class','item active'); 
            });
        </script>
  
<?php include("includes/footer.php");?>       
