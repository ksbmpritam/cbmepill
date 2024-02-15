<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

  if(isset($_POST['data_search']))
   {

      $qry="SELECT * FROM tbl_category                   
                  WHERE tbl_category.category_name like '%".addslashes($_POST['search_value'])."%'
                  ORDER BY tbl_category.category_name";
 
     $result=mysqli_query($mysqli,$qry); 

   }
   else
   {
	
	//Get all Category 
	 
      $tableName="tbl_pdf";   
      $targetpage = "manage_pdf.php"; 
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
      
     $qry="SELECT * FROM tbl_pdf  ORDER BY tbl_pdf.id DESC";// LIMIT $start, $limit";
 
     $result=mysqli_query($mysqli,$qry); 
	
    } 

	if(isset($_GET['cat_id']))
	{ 

		$cat_res=mysqli_query($mysqli,'SELECT * FROM tbl_pdf WHERE id=\''.$_GET['cat_id'].'\'');
		$cat_res_row=mysqli_fetch_assoc($cat_res);

		Delete('tbl_pdf','id='.$_GET['cat_id'].'');

     
		$_SESSION['msg']="12";
		header( "Location:manage_pdf.php");
		exit;
		
	}	

  function get_total_item($cat_id)
  { 
    global $mysqli;   

    $qry_songs="SELECT COUNT(*) as num FROM tbl_pdf WHERE cat_id='".$cat_id."'";
     
    $total_songs = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
    $total_songs = $total_songs['num'];
     
    return $total_songs;

  }

  //Active and Deactive status
if(isset($_GET['status_deactive_id']))
{
   $data = array('status'  =>  '0');
  
   $edit_status=Update('tbl_category', $data, "WHERE cid = '".$_GET['status_deactive_id']."'");
  
   $_SESSION['msg']="14";
   header( "Location:manage_category.php");
   exit;
}
if(isset($_GET['status_active_id']))
{
    $data = array('status'  =>  '1');
    
    $edit_status=Update('tbl_category', $data, "WHERE cid = '".$_GET['status_active_id']."'");
    
    $_SESSION['msg']="13";   
    header( "Location:manage_category.php");
    exit;
}  
	 
?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage PDF's</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  
                </div>
                <div class="add_btn_primary"> <a href="add_pdf.php">Add PDF</a> </div>
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
          <div class="row mrg-top" style="margin-right: 10px;">
              <input type="text" name="search" placeholder="search..." id="myInput">
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
              <form class="form-inline" method="post" style="float:right">
    <div class="form-group">
        
       <select name="cat_id" id="cat_id" class="select2" required>
           <option value="">Select Course</option>
           <?php 
              $cod=mysqli_query($mysqli,"select * from tbl_category");
              if(mysqli_num_rows($cod)>0){
                   while($cisds=mysqli_fetch_assoc($cod)){
               
           ?>
           <option value="<?=$cisds['cid'];?>"><?=$cisds['category_name'];?></option>
           <?php } } ?>
       </select>
       <script>
           $(document).ready(function(){
              $('#cat_id').change(function(){
                 $.ajax({
                                    url: "adnroid/subject.php", 
               method: "post",
               data: {id : $(this).val()} 
    })
    .done(function(response) {
        $('#subj').html(response);
                });    
              });
               
           });
       </script>
    </div>
    <div class="form-group">
      <select name="sub_id" id="subj" class="select2" required>
           <option value="">Select Subject</option>
       </select>
    </div>
    <button type="submit" name="gdsa" class="btn btn-warning ">Submit</button>
  </form>    
  <?php 
      $cuy='';$suy='';
      if(isset($_POST['gdsa']))
      {
          $cuy=$_POST['cat_id'];
          $_SESSION['cuy']=$cuy;
          
          $suy=$_POST['sub_id'];
          $_SESSION['suy']=$suy;
      }
   ?>
          </div>
          
          <table class="table table-bordered">
    <thead>
      <tr>
        <th>S. no</th>
        <th>Course</th>
        <th>Subject</th>
        <th>Title</th>
        <th>Video</th>
        <th>Number</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody id="myTable">
        <?php  
        //$qry="SELECT * FROM `tbl_pdf` WHERE `cat_id`='".$_SESSION['cuy']."' and `subject_id`='".$_SESSION['suy']."'  order by `rangee` asc "; 
        $qry="SELECT * FROM `tbl_pdf` order by `rangee` asc "; 

		$qry_result=mysqli_query($mysqli,$qry);
		$numrows=mysqli_num_rows($qry_result);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $s=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
		          $qr   = mysqli_query($mysqli,"select * from subject where id='".$row['subject_id']."'");
		          $row1 = mysqli_fetch_assoc($qr);
		          $qr1  = mysqli_query($mysqli,"select * from tbl_category where cid='".$row['cat_id']."'");
		          $row2 = mysqli_fetch_assoc($qr1);
		            
            ?>
        <form method="POST" >
      <tr style="" id="tr<?=$s?>">
        <td><?=$s;?></td>
        <td><?=$row2['category_name'];?></td>
        <td><?=$row1['subject_name'];?></td>
        <td><?=$row['pdf_name'];?></td>
        <td>
            <?php if($row['pdf']!='') {?><a href="http://angirasuratgarhlive.com/ksbmadmin/pdf/<?=$row['pdf'];?>" target="_blank"><img src="http://angirasuratgarhlive.com/ksbmadmin/images/pdfim.jpg" style="height:50px;width:50px;" ></i></a><?php } else {echo 'No Pdf';}?>
        </td>
        <td>
        
        <span class="token" id="token<?=$s;?>" data="<?=$s;?>"><?=$row['rangee'];?></span>
        
        
<select name="token" id="input<?=$s?>" style="border:none; display:none;">
     <?php $nu = mysqli_query($mysqli,"SELECT DISTINCT(`rangee`) as `rangee` FROM `tbl_pdf` where cat_id='".$_SESSION['cuy']."' and subject_id='".$_SESSION['suy']."'
                 order by `rangee` asc");
           if(mysqli_num_rows($nu)>0)
           {
               $nuhfbs=1;
             while($row3=mysqli_fetch_assoc($nu))
              {
     ?>
    <option value="<?=$row3['rangee'];?>" <?php if($row3['rangee']==$row['rangee']){ echo "selected";}?>><?=$nuhfbs++?></option>
    <?php }} ?>
</select>    
        <input type="hidden" name="user_id" value="<?=$row['id'];?>">
        </td>
        <td><input type="submit" style="padding:6px;" class="btn btn-success btn-sm" name="submit<?=$s?>" value="Update">
           </form> <a href="add_pdf.php?cat_id=<?php echo $row['id'];?>"  target='_blank'><button class="btn btn-danger btn-sm" style="padding:6px;" >Edit</button></a>
           <a href="?cat_id=<?php echo $row['id'];?>"  onclick="return confirm('Are you sure you want to delete this category?');"><button class="btn btn-danger btn-sm" style="padding:6px;" >Delete</button></a>
        </td>      
        </tr>
        
        
        <?php
             if(isset($_POST['submit'.$s]))
             {
                
                $queryget1=mysqli_query($mysqli,"SELECT * FROM `tbl_pdf` where `id`='".$_POST['user_id']."' and  cat_id='".$_SESSION['cuy']."' and subject_id='".$_SESSION['suy']."' ");
                $rode1=mysqli_fetch_assoc($queryget1);
                
                //second
                $queryget=mysqli_query($mysqli,"SELECT * FROM `tbl_pdf` where `rangee`='".$_POST['token']."' and  cat_id='".$_SESSION['cuy']."' and subject_id='".$_SESSION['suy']."' ");
                $rode=mysqli_fetch_assoc($queryget);
                
                if($queryget)
                {
                  $up1=mysqli_query($mysqli,"update `tbl_pdf` set `rangee`='".$rode['rangee']."' where id='".$rode1['id']."' and  cat_id='".$_SESSION['cuy']."' and subject_id='".$_SESSION['suy']."' ");
                  $up2=mysqli_query($mysqli,"update `tbl_pdf` set `rangee`='".$rode1['rangee']."' where id='".$rode['id']."'and  cat_id='".$_SESSION['cuy']."' and subject_id='".$_SESSION['suy']."' ");
                
                if($up2)
                 {
                     echo "<script>window.location.href='manage_pdf.php';</script>";
                     $_SESSION['msg']="11";
                 }    
                }
                
                
             }
        ?>
       
      <?php $s++;} } else {?>
      <tr>
          <td colspan="7" style="text-align:center;">No Data Found</td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  
  <script>
            $(document).ready(function(){
                $(".token").click(function(){
                    var one=$(this).attr('data');
                    var i=1;
                    for(i=1;i<=<?=$numrows?>;i++)
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
          
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
