<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  //'filters' => array(array('Area' => '=', 'value' => 'ALL')),

    if(isset($_REQUEST['pbl']))
    {
        $id=base64_decode($_REQUEST['pbl']); 
      echo   $qry="select * from notification where id='$id'";
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
      $qry="delete from `question` where id='$id'";
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
<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

.modal {
  display: none;
  position: fixed; 
  z-index: 1; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.9); 
}

.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}

/*.table-bordered img{
    width:100% !important;
}

.card{
       width: 1250px !important; 
}*/

table.table > tbody > tr td, table.table > tbody > tr th, table.table > thead > tr td {
    font-size: 14px;
    padding: 7px 15px!important;
    vertical-align: middle;
}

</style>
<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="row" style="overflow-y:scroll; width:1200px;">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">View Question</div>
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
          
          <div class="main" style="width:200px;">
            <table class="table table-bordered">
    <thead>
      <tr>
        <th>S. no</th>
        <th>Question</th>
        <th>Option A</th>
        <th>Option B</th>
        <th>Option C</th>
        <th>Option D</th>
        <th>Answer</th>
        <th>Question Image</th>
        <th>Option A Image</th>
        <th>Option B Image</th>
        <th>Option C Image</th>
        <th>Option D Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $id=base64_decode($_REQUEST['id']);
        mysqli_set_charset($mysqli,"utf8");
        $qry="select * from question where e_id='$id' order by id asc "; 
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
        <td><?=$row['Question'];?></td>
        <td><?=$row['option_1'];?></td>
        <td><?=$row['option_2'];?></td>
        <td><?=$row['option_3'];?></td>
        <td><?=$row['option_4'];?></td>
        <td><?php 
        if($row['answer']=='A'){  ?>
       
             <?php  if($row['image_opt1']!=''){ ?>
               <img src="images/ExamAns/<?=$row['image_opt1'];?>" id="myImg<?=$s;?>" style="">
             <?php } else { ?>
               <?php   echo $row['option_1']; ?>
          <?php    } ?>
          <?php    } ?>
  


         <?php   
           if($row['answer']=='B'){ ?>

              <?php  if($row['image_opt2']!=''){ ?>
               <img src="images/ExamAns/<?=$row['image_opt2'];?>" id="myImg<?=$s;?>" style="">
             <?php } else { ?>
               <?php   echo $row['option_2']; ?>
          <?php    } ?>
          <?php    } ?>
  
           




<?php

          if($row['answer']=='C'){ ?>

             <?php  if($row['image_opt3']!=''){ ?>
               <img src="images/ExamAns/<?=$row['image_opt3'];?>" id="myImg<?=$s;?>" style="">
             <?php } else { ?>
               <?php   echo $row['option_3']; ?>
          <?php    } ?>
          <?php    } ?>



            <?php
            if($row['answer']=='D'){  ?>
             
               <?php  if($row['image_opt4']!=''){ ?>
               <img src="images/ExamAns/<?=$row['image_opt4'];?>" id="myImg<?=$s;?>" style="">
             <?php } else { ?>
               <?php   echo $row['option_4']; ?>
          <?php    } ?>
          <?php    } ?>

          
             </td>
        <td><?php if($row['image']!=''){?><img src="images/ExamAns/<?=$row['image'];?>" id="myImg<?=$s;?>" ><?php } ?></td>

         <td><?php if($row['image_opt1']!=''){?><img src="images/ExamAns/<?=$row['image_opt1'];?>" id="myImg<?=$s;?>" style=""><?php } ?></td>

          <td><?php if($row['image_opt2']!=''){?><img src="images/ExamAns/<?=$row['image_opt2'];?>" id="myImg<?=$s;?>" style=""><?php } ?></td>

           <td><?php if($row['image_opt3']!=''){?><img src="images/ExamAns/<?=$row['image_opt3'];?>" id="myImg<?=$s;?>" style=""><?php } ?></td>

            <td><?php if($row['image_opt4']!=''){?><img src="images/ExamAns/<?=$row['image_opt4'];?>" id="myImg<?=$s;?>" style=""><?php } ?></td>

        <td><button type="button" style="padding:6px;"  onclick="window.location.href='edit_question.php?edit=<?=$id?>'" class="btn btn-warning btn-sm">Edit</button><button type="button" style="padding:6px;" class="btn btn-danger btn-sm" onclick="window.location.href='<?=$actual_link.'&del='.$id?>'">Delete</button></td>      
      </tr>
      <div id="myModal<?=$s;?>" class="modal">
  <span class="close" id="close1<?=$s;?>">&times;</span>
  <img class="modal-content" id="img01<?=$s;?>">
  <div id="caption<?=$s;?>"></div>
</div>
<script>
var modal = document.getElementById("myModal<?=$s;?>");

var img = document.getElementById("myImg<?=$s;?>");
var modalImg = document.getElementById("img01<?=$s;?>");
var captionText = document.getElementById("caption<?=$s;?>");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

var span = document.getElementById("close1<?=$s;?>");
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
      <?php  $s++;} }?>
    </tbody>
  </table>
  </div>
          </div>
        </div>
      </div>
    </div>
        
        
        
  
<?php include("includes/footer.php");?>       
