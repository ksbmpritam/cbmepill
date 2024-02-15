<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

    
    
    if(isset($_REQUEST['del']))
    {
       $id=base64_decode($_REQUEST['del']);
       $qry="delete from `contact` where id='$id'";
       $data_ins=mysqli_query($mysqli,$qry);
      if($data_ins)
      {
          
          header('Location: query.php');
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
              <div class="page_title">Inquey List</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <!--<div class="page_title pull-right"><button type="submit" name="submit" class="btn btn-primary" onclick="window.location.href='addexam.php'">Add Exam</button></div>
            --></div>
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
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Query</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $qry="SELECT * FROM `contact` order by id desc"; 
		$qry_result=mysqli_query($mysqli,$qry);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $s=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
		        $id=base64_encode($row['id']);
		        
        ?>
      <tr>
        <td><?=$s++;?></td>
        <td><?=$row['name'];?></td>
        <td><?=$row['email'];?></td>
        <td><?=$row['phone'];?></td>
        <td><?=$row['msg'];?></td>
        <td><button class="btn btn-sm btn-danger btn-sm" style="padding:6px;" onclick="window.location.href='query.php?del=<?=$id?>'">Delete</button></td>
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
