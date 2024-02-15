<?php include("includes/header.php");
require("includes/function.php");
require("language/language.php");

 $sql="SELECT * FROM `books_master`";
$query=mysqli_query($mysqli,$sql);


?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">All Books</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  <form method="post" action="">
                  <input class="form-control input-sm" placeholder="Search category..." aria-controls="DataTables_Table_0" type="search" name="search_value" required="">
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
                <div class="add_btn_primary"> <a href="add_new_book.php">Add New Book</a> </div>
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
          <div class="col-sm-12 col-xs-12">
            <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-sm table-responsive ">
       <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Book ID</th>
            <th>Book Title</th>
            <th>Author Name</th>
            <th>Book Category</th>
            <th>Book Publisher</th>
            <th>Cover Image</th>
            <th>Description</th>
            <th>Price</th>
            <th>Validity</th>
            
            <th>Status</th>
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
          <td><?php echo $row['book_title'];?></td>
          <td><?php echo $row['author_name'];?></td>
          <td><?php echo $row['book_category'];?></td>
          <td><?php echo $row['book_publisher'];?></td>
          <td><img src="upload_books/cover/<?php echo $row['book_cover_image'];?>"></td>
          <td><?php echo $row['book_description'];?></td>
          <td><?php echo $row['book_price'];?></td>
          <td><?php echo $row['book_validity'];?></td>
          <td><?php echo $row['book_status'];?></td>
          <td><?php echo $row['created_date'];?></td>
          <td><?php echo $row['updated_date'];?></td>
          <!--<td><span class="sp"><?php //echo $row['status'];?></span></td>-->
          <td>
              <a href="edit_book.php?id=<?php echo $row['id'];?>" class="btn btn-sm btn-info"><i class="fas fa-edit" aria-hidden="true"></i>Edit</a>
              <a class="btn btn-mini btn-danger" href="#delete<?php echo $row['id'];?>" data-toggle="modal">Delete</a>
              <?php include('delete_book_model.php'); ?>
          </td>
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
