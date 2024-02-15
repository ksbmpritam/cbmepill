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
		}
		if($qry_fet['published']=='0')
		{
		    $published='1';
		}
		
		$qry="update notification set published='$published' where id='$id'";
		$qry_result=mysqli_query($mysqli,$qry);
		$_SESSION['msg']="11";
    }
    
    if(isset($_REQUEST['del']))
    {
     $id=base64_decode($_REQUEST['del']);
     $qry="delete from footerimage where id='$id'";
	 $qry_o=mysqli_query($mysqli,$qry);
	 $_SESSION['msg']="12";
    }
 
  
   

?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Footer Banner</div>
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
        <th>Name</th>
        <th>Image</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $qry="select * from footerimage order by id desc"; 
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
        <td><?=$row['image_name'];?></td>
        <td><img src="images/footerimage/<?=$row['image'];?>" style="width: 100px !important;"></td>
        <td><button class="btn btn-sm btn-info" onclick="window.location.href='footerbanner.php?edit=<?=$id?>'">Edit</button><button class="btn btn-sm btn-danger" onclick="window.location.href='footerbannerlist.php?del=<?=$id?>'">Delete</button></td>
      </tr>
      <?php } }?>
    </tbody>
  </table>
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
