<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  //'filters' => array(array('Area' => '=', 'value' => 'ALL')),

    if(isset($_REQUEST['pbl']))
    {
        $id=base64_decode($_REQUEST['pbl']); 
        $qry="select * from notification where id='$id'";
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
		        $insnoti=mysqli_query($mysqli,"insert into notificationseen(`userid`, `notiification`) values('".$row['user_id']."','$id')");
		    }
		}
		
		$qry="update notification set published='$published' where id='$id'";
		$qry_result=mysqli_query($mysqli,$qry);
		$_SESSION['msg']="11";
    }
    
    if(isset($_REQUEST['del']))
    {
       $id=base64_decode($_REQUEST['del']);
      $getre='0';
      $qry="delete from `newevent` where id='$id'";
      $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
        
        $imagelist=mysqli_query($mysqli,"select * from neweventgallery where eventid='$id'");
        if(mysqli_num_rows($imagelist)>0)
        {
            $url='images/event/';
            while($image=mysqli_fetch_assoc($imagelist))
            {
                unlink($url.$image['image']);
            }
        }
        
        $imagedel=mysqli_query($mysqli,"delete from neweventgallery where eventid='$id'");
        if($imagedel)
         {
           $getre='1'; 
         }
        }
        
        if($getre=='1')
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
              <div class="page_title">Event List</div>
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
            <table class="table table-bordered">
    <thead>
      <tr>
        <th>S. no</th>
        <th>Title</th>
        <th>Discription</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $qry="select * from newevent order by id desc"; 
		$qry_result=mysqli_query($mysqli,$qry);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $s=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
		        $id=base64_encode($row['id']);
        ?>
      <tr>
        <td><?=$s;?></td>
        <td><?=$row['title'];?></td>
        <td><?=$row['discription'];?></td>
        <td><?php  $old_date_timestamp = strtotime($row['date']); echo $new_date = date('d-m-Y', $old_date_timestamp);$row['date'];?></td>
        <td><button type="button" class="btn btn-warning" onclick="window.location.href='eventadd.php?edit=<?=$id?>'">Edit</button><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?=$s++;?>">View Image</button><button class="btn btn-sm btn-danger" onclick="window.location.href='neweventlist.php?del=<?=$id?>'">Delete</button></td>
      </tr>
      <?php } }?>
    </tbody>
  </table>
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
