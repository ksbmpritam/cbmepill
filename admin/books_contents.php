<?php include("includes/header.php");
require("includes/function.php");
require("language/language.php");

 $sql="SELECT * FROM `book_contents`";
$query=mysqli_query($mysqli,$sql);


?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">All Books Contents</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  <form method="post" action="">
                  <input class="form-control input-sm" placeholder="Search category..." aria-controls="DataTables_Table_0" type="search" name="search_value" required="">
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
                <div class="add_btn_primary"> <a href="add_book_contents.php">Add Book Contents</a> </div>
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
<table class="table table-striped table-bordered table-hover table-responsive ">
    <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Book ID</th>
            <th>Page No</th>
            <th>Page Type</th>
            <th>Page Image</th>
            <th>Created Date</th>
            <th>Updated Date</th>
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
          <td><?php echo $i;?></td>
          <td><?php echo $row['book_id'];?></td>
          <td><?php echo $row['page_no'];?></td>
          <td><?php echo $row['page_type'];?></td>
          <td><img src="upload_books/page/<?php echo $row['page_image'];?>"></td>
          <td><?php echo $row['created_date'];?></td>
          <td><?php echo $row['updated_date'];?></td>
          <!--<td><span class="sp"><?php //echo $row['status'];?></span></td>-->
          <td><a href="edit_book_contents.php?id=<?php echo $row['id'];?>" class="btn btn-sm btn-danger"><i class="fas fa-edit" aria-hidden="true"></i>Edit</a></td>
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
