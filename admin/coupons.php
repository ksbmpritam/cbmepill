<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

 $sql="SELECT * FROM `coupons_master`";
$query=mysqli_query($mysqli,$sql);


?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">All Coupons</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  <form method="post" action="">
                  <input class="form-control input-sm" placeholder="Search category..." aria-controls="DataTables_Table_0" type="search" name="search_value" required="">
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
                <div class="add_btn_primary"> <a href="addedit_coupons.php?add=yes">Add Coupons</a> </div>
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
 




<table   class="table table-striped table-bordered table-hover ">
    <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Coupon Name</th>
            <th>Flat Type</th>
            <th>Flat Value</th>
            <th>Min Value</th>
            <th>Max Value</th>
            
            <th>Attempts</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Details</th>
            <th>Status</th>
            <th>Action</th>
          
   

        </tr>
    </thead>
    <tbody id="myTable">
   
    <center>  <b></b></center>
                <?php 
            $i=1;
            while($row=mysqli_fetch_assoc($query))
            {         
        ?>
        <tr>
          <td><span class="sp"><?php echo $i;?></span></td>
          <td><span class="sp"><?php echo $row['coupons_name'];?></span></td>
          <td><span class="sp"><?php echo $row['coupons_flat_type'];?></span></td>
          <td><span class="sp"><?php echo $row['coupons_flat_value'];?></span></td>
          <td><span class="sp"><?php echo $row['apply_flat_min'];?></span></td>
          <td><span class="sp"><?php echo $row['apply_flat_max'];?></span></td>
          <td><span class="sp"><?php echo $row['coupons_attempts'];?></span></td>
          <td><span class="sp"><?php echo $row['coupons_from'];?></span></td>
          <td><span class="sp"><?php echo $row['coupons_to'];?></span></td>
          <td><span class="sp"><?php echo $row['coupons_details'];?></span></td>
          <td><span class="sp"><?php echo $row['status'];?></span></td>
          <td><button class="btn btn-sm btn-danger" onclick="window.location.href='addedit_coupons.php?edit=<?=base64_encode($row['id']);?>'"><i class="fas fa-edit" aria-hidden="true"></i></button></td>
 
         	
         
		   
		            
		   
        </tr>
          <?php
            
            $i++;
              }
        ?>     
         
  </tbody>
</table>




 
       
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
