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

	if(isset($_GET['del']))
	{ 
	    $id=base64_decode($_GET['del']);

		$cat_res=mysqli_query($mysqli,"DELETE FROM exam WHERE id='$id'");
		if($cat_res)
		{
		  $_SESSION['msg']="12";
		  $statusMsg = "Exam Deleted  successfully !";
		//header( "Location:manage_exam.php");
		//exit;    
		}
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
            <div class="col-md-3 col-xs-12">
              <div class="page_title">Manage Exam</div>
            </div>
            
            <div class="col-md-7 col-xs-12" style="margin-top:20px;">
                
              </div>
            
            <div class="col-md-2 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  
                </div>
                <div class="add_btn_primary"> <a onclick="window.location.href='addexam.php'">Add Exam</a> </div>
              </div>
            </div>
          </div>
           <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
              <div class="col-md-12 col-sm-12">
                <?php if($statusMsg){?> 
                 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <?php echo $statusMsg ; ?></a> </div>
                <?php unset($statusMsg);}?>	 
              </div>
            </div>
          </div>
          <div class="row mrg-top" style="margin-right: 10px;">
              <input type="text" name="search" placeholder="Search..." id="myInput" class="search-bar-pk">
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
        
       <select name="cat_id" id="cat_id" class="select2" style="width:160px !important;" required>
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
      <select name="sub_id" id="subj" class="select2" style="width:160px !important;" required>
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
        <th>Exam Name</th>
        <th>From Server</th>
        <th>Number</th>
        <th>Is Published ?</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody id="myTable">
        <?php  
        $qry="SELECT * FROM `exam` WHERE `courseid`='".$_SESSION['cuy']."' and `subjectid`='".$_SESSION['suy']."'  order by `rangee` asc "; 
		$qry_result=mysqli_query($mysqli,$qry);
		$numrows=mysqli_num_rows($qry_result);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $s=1; $copy=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
		          $id=base64_encode($row['id']);
		          $qr   = mysqli_query($mysqli,"select * from subject where id='".$row['subjectid']."'");
		          $row1 = mysqli_fetch_assoc($qr);
		          $qr1  = mysqli_query($mysqli,"select * from tbl_category where cid='".$row['courseid']."'");
		          $row2 = mysqli_fetch_assoc($qr1);
		            
            ?>
        
      <tr style="" id="tr<?=$s?>">
        <td><?=$s;?></td>
        <td><?=$row2['category_name'];?></td>
        <td><?=$row1['subject_name'];?></td>
        <td><?=$row['name'];?></td>
        <td>
            <form method="post">
            <select name="name" id="cat_id" class="select2" required>
                        <option value="">--Select MCQ--</option>
          							<?php
          							        $nameget=mysqli_query($mysqli,"SELECT DISTINCT(e_id) FROM `question` ");
          									while($cat_row=mysqli_fetch_array($nameget))
          									{   
          									    $e_id=$cat_row['e_id'];
          									    $mcqname=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT name FROM `exam` where id='$e_id'"))['name'];
          									    if($mcqname!=''){
          							?>          						 
          							<option value="<?=$e_id;?>" ><?php if($mcqname!=''){ echo $mcqname;}?></option>	          							 
          							<?php
          								} }
          							?>
                      </select><input type="submit" class="btn btn-success btn-sm " value="update" name="update<?=$copy;?>" style="background-color: #18aa4a;"></form>
        </td>
        <td>
        
        <span class="token" id="token<?=$s;?>" data="<?=$s;?>"><?=$row['rangee'];?></span>
        
       <form method="POST" > 
<select name="token" id="input<?=$s?>" style="border:none; display:none;">
     <?php $nu = mysqli_query($mysqli,"SELECT DISTINCT(`rangee`) as `rangee` FROM `exam` where `courseid`='".$_SESSION['cuy']."' and `subjectid`='".$_SESSION['suy']."'
                 order by `rangee` asc");
           if(mysqli_num_rows($nu)>0)
           {
               $nuhfbs=1;
             while($row3=mysqli_fetch_assoc($nu))
              {
                  $examId=$row3['id'];
     ?>
    <option value="<?=$row3['rangee'];?>" <?php if($row3['rangee']==$row['rangee']){ echo "selected";}?>><?=$nuhfbs++?></option>
    <?php }} ?>
</select>    
        <input type="hidden" name="user_id" value="<?=$row['id'];?>">
        </td>
        <td><?=($row['is_published'] == 1) ? "Yes" : "No";?></td>
        <td><input type="submit" style="padding:6px;" class="btn btn-success btn-sm" name="submit<?=$s?>" value="Update">
           </form> 
           <button type="button" style="padding:6px;" class="btn btn-warning btn-sm" onclick="window.location.href='addexam.php?edit=<?=$id?>'">Edit</button>&nbsp;
           <button type="button" style="padding:6px;" class="btn btn-info btn-sm" onclick="window.location.href='add_question.php?id=<?=$id?>'">Add Question</button>&nbsp;
           <button type="button" style="padding:6px;" class="btn primary btn-sm" onclick="window.location.href='viewquestion.php?id=<?=$id?>'">View Question</button>&nbsp;
           <a href="delete_exam.php?id=<?=$row['id'];?>">
               <button type="button" id="delete_exam.php<?=$id?>" class="btn btn-sm btn-danger btn-sm" style="padding:6px;" >Delete</button>&nbsp;
           </a>
           <a href="import_question.php?id=<?=$id?>" class="btn btn-xs btn-danger"><i class="fa fa-upload" aria-hidden="true"></i> Import</a>&nbsp;
           <!--<a href="export_question.php?id=<?=$id?>" class="btn btn-xs btn-success"><i class="fas fa-download" aria-hidden="true"></i> Export</a>-->
           <a href="export_question.php?downlaod=<?=$row['id'];?>" class="btn btn-xs btn-success"><i class="fas fa-download" aria-hidden="true"></i> Export</a>
        </td>      
        </tr>
        
        
        <?php
             if(isset($_POST['submit'.$s]))
             {
                
                $queryget1=mysqli_query($mysqli,"SELECT * FROM `exam` where `id`='".$_POST['user_id']."' and  courseid='".$_SESSION['cuy']."' and subjectid='".$_SESSION['suy']."' ");
                $rode1=mysqli_fetch_assoc($queryget1);
                
                //second
                $queryget=mysqli_query($mysqli,"SELECT * FROM `exam` where `rangee`='".$_POST['token']."' and  courseid='".$_SESSION['cuy']."' and subjectid='".$_SESSION['suy']."' ");
                $rode=mysqli_fetch_assoc($queryget);
                
                if($queryget)
                {
                  $up1=mysqli_query($mysqli,"update `exam` set `rangee`='".$rode['rangee']."' where id='".$rode1['id']."' and  courseid='".$_SESSION['cuy']."' and subjectid='".$_SESSION['suy']."' ");
                  $up2=mysqli_query($mysqli,"update `exam` set `rangee`='".$rode1['rangee']."' where id='".$rode['id']."'and  courseid='".$_SESSION['cuy']."' and subjectid='".$_SESSION['suy']."' ");
                
                if($up2)
                 {
                     echo "<script>window.location.href='manage_exam1.php';</script>";
                     $_SESSION['msg']="11";
                 }    
                }
                
                
             }
             
             if(isset($_POST['update'.$copy]))
         {
             $nsme=$_POST['name'];
             $treu=1;
             
             $delqyery=mysqli_query($mysqli,'DELETE FROM `question` where  e_id="'.$row['id'].'"');
             if($delqyery){
             $nameget=mysqli_query($mysqli,"SELECT * FROM `question` where e_id='$nsme'");
             if(mysqli_num_rows($nameget)>0)
             {
                 while($ros=mysqli_fetch_assoc($nameget))
                 {
                  $Question=$ros['Question'];
                     $option_1=$ros['option_1'];
                     $option_2=$ros['option_2'];
                     $option_3=$ros['option_3'];
                     $option_4=$ros['option_4'];
                     $answer=$ros['answer'];
                     $image=$ros['image'];
                     $ins=mysqli_query($mysqli,'INSERT INTO `question`(`e_id`, `Question`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`, `image`) VALUES ("'.$row['id'].'","'.$Question.'","'.$option_1.'","'.$option_2.'","'.$option_3.'","'.$option_4.'","'.$answer.'","'.$image.'")');    
                     if($ins)
                     {
                      $treu*=1;     
                     }
                     else
                     {
                        $treu*=0; 
                     }
                 }
                 if($treu==1)
                 {
                  $_SESSION['msg']="11";   
                  echo "<script>window.href.location='http://padhakuji.com/manage_exam.php';</script>";     
                 }
             }
             } 
         }
      
      $copy++;
             
             
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

<script>
    $('#Delete_exam<?=$id?>').click(function(){
        
    var id='<?=$id?>';
    //alert('click'+id);
        
    });
</script>
