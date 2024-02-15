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
              <div class="page_title">Exam List</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="page_title pull-right"><button type="submit" name="submit" class="btn btn-primary" onclick="window.location.href='addexam.php'">Add Exam</button></div>
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
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
            <table class="table table-bordered">
    <thead>
      <tr>
        <th>S. no</th>
        <th>Course</th>
        <th>Subject</th>
        <th>Exam Name</th>
        <th>From Server</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $qry="select * from exam order by id desc"; 
		$qry_result=mysqli_query($mysqli,$qry);
		if(mysqli_num_rows($qry_result)>0)
		{
		    $s=1; $copy=1;
		    while($row=mysqli_fetch_assoc($qry_result))
		    {
		        $id=base64_encode($row['id']);
		        $course=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT `category_name` FROM `tbl_category` WHERE `cid`='".$row['courseid']."'"))['category_name'];
		        $subject=mysqli_fetch_assoc(mysqli_query($mysqli,"select subject_name from subject where id='".$row['subjectid']."'"))['subject_name'];
        ?>
      <tr>
        <td><?=$s++;?></td>
        <td><?=$course;?></td>
        <td><?=$subject;?></td>
        <td><?=$row['name'];?></td>
        <form method="post">
            <input type="hidden" name="bivo" value="ddc">
        <td><select name="name" id="cat_id" class="select2" required>
                        <option value="">--Select MCQ--</option>
          							<?php
          							        $nameget=mysqli_query($mysqli,"SELECT DISTINCT(e_id) FROM `question` order by id desc");
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
                      </select></td>
        <td><input type="submit" class="btn btn-success btn-sm " value="update" name="update<?=$copy;?>" style="background-color: #18aa4a;"></form><br><button type="button" style="padding:6px;" class="btn btn-warning btn-sm" onclick="window.location.href='addexam.php?edit=<?=$id?>'">Edit</button><button type="button" style="padding:6px;" class="btn btn-info btn-sm" onclick="window.location.href='add_question.php?id=<?=$id?>'">Add Question</button><button type="button" style="padding:6px;" class="btn primary btn-sm" onclick="window.location.href='viewquestion.php?id=<?=$id?>'">View Question</button><button class="btn btn-sm btn-danger btn-sm" style="padding:6px;" onclick="window.location.href='manage_exam.php?del=<?=$id?>'">Delete</button></td>
      </tr>
      <?php
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
      
      $copy++;} }?>
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
