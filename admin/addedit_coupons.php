<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

if(isset($_REQUEST['edit'])){
    $id=base64_decode($_REQUEST['edit']);
     $query=mysqli_query($mysqli,"SELECT * FROM coupons_master where id='".$id."'");
	  $row=mysqli_fetch_assoc($query);
	  
	  $date_from=date_create($row['coupons_from']);
  $date_from=date_format($date_from,"Y-m-d");
  
  
   $date_to=date_create($row['coupons_to']);
  $date_to=date_format($date_to,"Y-m-d");

	
	
}

	if(isset($_POST['submit'])) 
	{
	   
	    $coupensName=$_POST['CouponsName'];
	    $FlatDiscount=$_POST['FlatDiscount'];
	    $MinValue=$_POST['MinValue'];
	    $MaxValue=$_POST['MaxValue'];
	    $Attempt=$_POST['Attempt'];
	    $From=$_POST['From'];
	    $to=$_POST['to'];
	    $details=$_POST['details'];
	    $FlatValue=$_POST['FlatValue'];
	    $createdDate=date("Y/m/d");
	    
	    
	    $sql="INSERT INTO `coupons_master` (`coupons_name`,`coupons_flat_type`,`coupons_flat_value`,`apply_flat_min`,`apply_flat_max`,`coupons_attempts`,`coupons_from`,`coupons_to`,`coupons_details`,`status`,`created_date`)
	                                        VALUES('$coupensName','$FlatDiscount','$FlatValue','$MinValue','$MaxValue','$Attempt','$From','$to','$details','1','$createdDate')";
	                                        
	                                        $query=mysqli_query($mysqli,$sql);
	                                        if($query){
	                                            //echo"dfasr";
	                                        }
	}elseif(isset($_POST['edit'])){
	    
	    $id=$_POST['coupon_id'];
	    $coupensName=$_POST['CouponsName'];
	    $FlatDiscount=$_POST['FlatDiscount'];
	    $MinValue=$_POST['MinValue'];
	    $MaxValue=$_POST['MaxValue'];
	    $Attempt=$_POST['Attempt'];
	    $From=$_POST['From'];
	    $to=$_POST['to'];
	    $details=$_POST['details'];
	    $FlatValue=$_POST['FlatValue'];
	    $createdDate=date("Y/m/d");
	    
	    $sqls="UPDATE `coupons_master` SET `coupons_name`='$coupensName',`coupons_flat_type`='$FlatDiscount',`coupons_flat_value`='$FlatValue',`apply_flat_min`='$MinValue',`apply_flat_max`='$MaxValue',`coupons_attempts`='$Attempt',`coupons_from`='$From',`coupons_to`='$to',`coupons_details`='$details',`updated_date`='$createdDate' WHERE `id`='$id'";
	   $query=mysqli_query($mysqli,$sqls);
	   if( $query){
	      
	       echo"<script>alert('Update Successfully');
	       window.location.href = 'coupons.php';

	       </script>";
	   }
	}
     


	
	 
	  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>


<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Add Coupons</div>
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
            <form   method="post" class="form form-horizontal" enctype="multipart/form-data">
 
 
 
              <div class="section">
                <div class="section-body">
                     <div class="form-group">
                    <label class="col-md-3 control-label"> Name:-</label>
                    <div class="col-md-6">
                        <input type="hidden" name="coupon_id" value="<?=  $row['id']; ?>">
                      <input type="text" name="CouponsName" required value="<?php if(isset($_REQUEST['edit'])){ echo $row['coupons_name'];}?>" placeholder="Coupons Name" class="form-control">
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label">Flat  :-</label>
                    <div class="col-md-6">
                      <select class="form-control "  required  name="FlatDiscount" >
                          <option value=""  >Select One</option>
                          <option value="Flat Percentage" <?php  if($row['coupons_flat_type']=='Flat Percentage'){echo"selected";}  ?> >Flat Percentage</option>
                          <option value="Flat Amount" <?php  if($row['coupons_flat_type']=='Flat Amount'){echo"selected";}  ?> >Flat Amount</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <br>
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label"> Flat Value:-</label>
                    <div class="col-md-6">
                      <input type="number" name="FlatValue" required value="<?php if(isset($_REQUEST['edit'])){ echo $row['coupons_flat_value'];}?>" placeholder="Flat Value" class="form-control">
                    </div>
                  </div>
                  <br>
                   <div class="form-group">
                    <label class="col-md-3 control-label"> Min:-</label>
                    <div class="col-md-6">
                      <input type="number" name="MinValue" required value="<?php if(isset($_REQUEST['edit'])){ echo $row['apply_flat_min'];}?>" placeholder="Apply Min Value" class="form-control">
                    </div>
                  </div>
                  
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label"> Max:-</label>
                    <div class="col-md-6">
                      <input type="number" name="MaxValue" required value="<?php if(isset($_REQUEST['edit'])){ echo $row['apply_flat_max'];}?>" placeholder="Apply Max Value" class="form-control">
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label"> Attempt:-</label>
                     <div class="col-md-6">
                      <select class="form-control "  required name="Attempt" >
                          <option value=""  >Select One</option>
                          <option value="1" <?php  if($row['coupons_attempts']==1){echo"selected";}  ?>>1 Time</option>
                          <option value="2"  <?php  if($row['coupons_attempts']==2){echo"selected";}  ?>>2 Time</option>
                          <option value="3"  <?php  if($row['coupons_attempts']==3){echo"selected";}  ?>>3 Time</option>
                          <option value="4"  <?php  if($row['coupons_attempts']==4){echo"selected";}  ?>>4 Time</option>
                          <option value="5"  <?php  if($row['coupons_attempts']==5){echo"selected";}  ?>>5 Time</option>
                          <option value="6" <?php  if($row['coupons_attempts']==6){echo"selected";}  ?> >6 Time</option>
                      </select>
                    </div>
                  </div>
                   <br>
                   <br>
                  
                  
                  
                    <div class="form-group">
                    <label class="col-md-3 control-label"> From :-</label>
                    <div class="col-md-6">
                      <input type="date" name="From" required value="<?php if(isset($_REQUEST['edit'])){ echo $date_from;}     ?>" class="form-control">
                    </div>
                  </div>
                  <br>
                  
                  
                   <div class="form-group">
                    <label class="col-md-3 control-label"> To :-</label>
                    <div class="col-md-6">
                      <input type="date" name="to" required value="<?php if(isset($_REQUEST['edit'])){ echo $date_to;}?>" class="form-control">
                    </div>
                  </div>
          
                  <br>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Details :-</label>
                    <div class="col-md-6">
                       <textarea cols="55" id="ditor5" required name="details" rows="10" data-sample-short=""> <?php if(isset($_REQUEST['edit'])){ echo $row['coupons_details'];}?></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="<?php if($_GET['add']=='yes'){echo"submit";}else{echo"edit";} ?>" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
