<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

 
	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result=mysqli_query($mysqli,$cat_qry); 
	
	
	if(isset($_GET['del']) && $_GET['del'] && $_GET['userid'] ){
	  $delmsg="";
	    $del_cacba_id=$_GET['del'];
        $id_base64en=$_GET['userid'];
        $del_cacba_id_decode=base64_decode($del_cacba_id);
        
        $sql_sel_Data="SELECT * from custom_assign_course_byadmin where cacba_id='$del_cacba_id_decode'";
          $data=mysqli_query($mysqli,$sql_sel_Data);
          $get_old_Data=mysqli_fetch_assoc($data);
        if($get_old_Data){
          
            $delcacba_user_id  =  $get_old_Data['cacba_user_id'];
			    $cacba_course_id  = $get_old_Data['cacba_course_id'];
			    $cacba_subjects_ids  = $get_old_Data['cacba_subjects_ids'];
              
          if($delcacba_user_id){
          $delmsg.=removeupdate_customer_course_subjectby_userid($delcacba_user_id,$cacba_course_id,$cacba_subjects_ids);
          }
            
        }
        
       
       $delsqls="DELETE FROM `custom_assign_course_byadmin` WHERE `cacba_id` = $del_cacba_id_decode ";
       $query=mysqli_query($mysqli,$delsqls);
    
    	if(mysqli_affected_rows($mysqli)>0){
    	$_SESSION['msg']="Record Deleted successfully".$delmsg;//.$sqls ;
    	}else{
    	$_SESSION['msg']="Record Not Deleted".$delmsg;//.$sqls;
    	}
     	header( "Location:custom_assign.php?userid=".$id_base64en);
		exit;	
        
	}
	if(isset($_POST['update_submit'])) 
	{
	    $cacba_id=$_POST['update_cacba_id'];
        $id=$_POST['update_user_id'];
        $id_base64en=base64_encode($id);
        $cacba_user_id = $_POST['user_id'];
	    $cacba_course_id  =  $_POST['update_cat_id'];
	    $cacba_subjects_ids  =  $_POST['update_sub_ids'];
        $cacba_note=$_POST['update_custom_note'];
			    
		$sqls="UPDATE `custom_assign_course_byadmin` SET `cacba_note`='$cacba_note',`cacba_course_id`='$cacba_course_id',`cacba_subjects_ids`='$cacba_subjects_ids' WHERE `cacba_id`='$cacba_id'";
	    $query=mysqli_query($mysqli,$sqls);
    	if(mysqli_affected_rows($mysqli)>0){
        $dd=update_customer_course_subjectby_userid($id,$_POST['update_cat_id'],$_POST['update_sub_ids']);
       	$_SESSION['msg']="Record Update successfully".$dd;//.$sqls ;
    	}else{
    	$_SESSION['msg']="Record Update successfully But you dont make any changes";//.$sqls;
    	}
     	header( "Location:custom_assign.php?userid=".$id_base64en);
		exit;	
    }
	if(isset($_POST['submit'])) 
	{
	  print_r($_POST);
	//  die();
        $id=$_POST['user_id'];
        $id_base64en=base64_encode($id);
    //           $data = array( 
			 //   "cacba_user_id"  =>  $id,
			 //   "cacba_course_id"  =>  $_POST['cat_id'],
			 //   "cacba_subjects_ids"  =>  $_POST['sub_ids'],
    //             "cacba_note"  =>  $_POST['custom_note'],
			 //   );
			    $cacba_user_id =  $id;
			    $cacba_course_id  =  $_POST['cat_id'];
			    $cacba_subjects_ids  =  implode(',',$_POST['sub_ids']);
                $cacba_note  =  $_POST['custom_note'];
			    
          echo      $insertsql="INSERT INTO `custom_assign_course_byadmin`( `cacba_user_id`, `cacba_course_id`, `cacba_subjects_ids`, `cacba_note`) VALUES ('".$cacba_user_id."','".$cacba_course_id."','".$cacba_subjects_ids."','".$cacba_note."')";
	
		//$lastid = Insertwith_lastid('custom_assign_course_byadmin',$data);	
        mysqli_query($mysqli, $insertsql) or die( mysqli_error($mysqli) );
        $lastid=mysqli_insert_id($mysqli);
  
    	if($lastid){
    	$dd=update_customer_course_subjectby_userid($id,$cacba_course_id,$cacba_subjects_ids);
    	
    	$_SESSION['msg']="Record add successfully".$dd .$insertsql;
    	
    	    
    	}else{
    	$_SESSION['msg']="Record Not add Plz try again";
    	    
    	}
     	header( "Location:custom_assign.php?userid=".$id_base64en);
		exit;	
    }

$id=base64_decode($_GET['userid']);
$sqli="SELECT * from user where user_id='$id'";
$data=mysqli_query($mysqli,$sqli);
$user=mysqli_fetch_assoc($data);
//print_r($user);	
	  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">
                  
            <?php 
             //edit code here
             if(isset($_GET['edit_mode']) && $_GET['edit_mode']){
                echo "Update Assing Course";
             }else{
                 echo "Assing Course";

             }    
             ?>
                  </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $_SESSION['msg'] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
            
          </div>
            <div class="row">
                    <div class="col-md-1"> 
                    </div>
                    <div class="col-md-6"> 
                        User Name  : <?php echo $user['name']; ?>
                        <BR/>Moblie : <?php echo $user['mobile']; ?>
                        <BR/>Email  : <?php echo $user['email']; ?></h2>
                    </div>
                    
                    <div class="col-md-5"> 
                    
                     Course_id: <?php $userid=$user['user_id']; echo get_user_old_data($userid , 'csid');?>  
                     <BR/> Subjects_id: <?php echo get_user_old_data($userid , 'subid');?>  
                
                    </div>     
            </div>
            <hr/>
         <div class="card-body mrg_bottom">
            <!-- Nav tabs -->
            
            <?php 
             //edit code here
             if(isset($_GET['edit_mode']) && $_GET['edit_mode']){
            
            
$id=base64_decode($_GET['edit_mode']);
$sqlupdate_Data="SELECT * from custom_assign_course_byadmin where cacba_id='$id'";
$data=mysqli_query($mysqli,$sqlupdate_Data);
$update_Data=mysqli_fetch_assoc($data);
             ?>
            <form action="" name="updat_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
                <input type="hidden" value="<?= $update_Data['cacba_id'];?>" name="update_cacba_id">          
                <input type="hidden" value="<?= $update_Data['cacba_user_id'];?>" name="update_user_id">          
        
              <div class="section">
                <div class="section-body">
                  <!-- <div class="form-group">-->
                  <!--  <label class="col-md-3 control-label">User  :-</label>-->
                  <!--  <div class="col-md-6"> -->
                  <!--      <div class="row"> -->
                  <!--      <div class="col-md-6"> -->
                  <!--       <?php echo $user['name']; ?>&nbsp; <?php echo $user['mobile']; ?>&nbsp;<?php echo $user['email']; ?>-->
                  <!--      </div>-->
                  <!--      </div>-->
                  <!--  </div>-->
                  <!--</div>-->
                
                   <div class="form-group">
                    <label class="col-md-3 control-label">Course :-</label>
                    <div class="col-md-6">
                      <select name="update_cat_id" id="cat_id2" class="select2" required value1="<?=$update_Data['cacba_course_id']?>">
                        <option value="">--Select Course--</option>
          							<?php
          							//`cacba_course_id`, `cacba_subjects_ids`,
          							         $selected_data=$update_Data['cacba_course_id'];
          									while($cat_row=mysqli_fetch_array($cat_result))
          									{
          									  $selected=($selected_data == $cat_row['cid'])? "selected" : "";
        							?>          						 
          							<option value="<?php echo $cat_row['cid'];?>" <?= $selected; ?>><?php echo $cat_row['category_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Subject :-</label>
                  <div class="col-md-6">
                      <select name="update_sub_ids" id="subj2" class="select2" required multiple  value1="<?=$update_Data['cacba_subjects_ids']?>">
                              <option value="">--Select Subject--</option>
    
                    <?php
                        $html="";
                           $cacba_course_id_up= $update_Data['cacba_course_id'];
                           $selected_cacba_subjects_ids_array=explode(',',$update_Data['cacba_subjects_ids']);
                          $query="select * from subject where course_id='$cacba_course_id_up'";
                            $result_cc = mysqli_query($mysqli, $query);

    $d_cc=mysqli_fetch_all($result_cc, MYSQLI_ASSOC);
        foreach($d_cc as $record)
        {
            
        $selected="";
        if (in_array($record['id'], $selected_cacba_subjects_ids_array)){
        $selected="selected";
        }

    	$html.='<option value='.$record['id'].'  '.$selected.'>'.$record['subject_name'].'</option>';
        }
    echo $html;    
?>
                      </select>
                    </div>
                  </div>
                  <script>
                      $(document).ready(function(){
                         $('#cat_id2').change(function(){
                            var id=$(this).val();
                            $.ajax({
                                    url: "adnroid/subject_forassign.php", 
               method: "post",
               data: {id : $(this).val()} 
    })
    .done(function(response) {
        $('#subj2').html(response);
        $('#subj2').html(response);
                });
                         });
                      });
                  </script>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Note :-</label>
                    <div class="col-md-6">
                      <input type="text" name="update_custom_note" id="" value="<?=$update_Data['cacba_note']?>" class="form-control" required>
                    </div>
                  </div>
                  
                  <br>
                  
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        
                      <input type="submit" name="update_submit" class="btn btn-primary" value="Update Course">
                      <a href="custom_assign.php?userid=<?=$_GET['userid'];?>" class="btn btn-danger">Cancel</a>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <?php 
             //edit code close
                 
             }else{
              //not edit mode 
            ?>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#app_assign" aria-controls="app_settings" role="tab" data-toggle="tab">Add Course</a></li>
                <li role="presentation"><a href="#listing" aria-controls="admob_settings" role="tab" data-toggle="tab">List</a></li>
            </ul>
          
           <div class="tab-content">
              
              <div role="tabpanel" class="tab-pane active" id="app_assign">	  
    
            <form action="" name="add_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            
              <div class="section">
                <div class="section-body">
                  <!-- <div class="form-group">-->
                  <!--  <label class="col-md-3 control-label">User  :-</label>-->
                  <!--  <div class="col-md-6"> -->
                  <!--      <div class="row"> -->
                  <!--      <div class="col-md-6"> -->
                  <!--       <?php echo $user['name']; ?>&nbsp; <?php echo $user['mobile']; ?>&nbsp;<?php echo $user['email']; ?>-->
                  <!--      </div>-->
                  <!--      </div>-->
                  <!--  </div>-->
                  <!--</div>-->
                
                   <div class="form-group">
                    <label class="col-md-3 control-label">Course :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" required>
                        <option value="">--Select Course--</option>
          							<?php
          									while($cat_row=mysqli_fetch_array($cat_result))
          									{
          							?>          						 
          							<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Subject :-</label>
                  <div class="col-md-6">
                      <select name="sub_ids[]" id="subj44" class="select2" multiple  required>
                          <option value="">--Select Subject--</option>
                      </select>
                    </div>
                  </div>
                  <script>
                      $(document).ready(function(){
                         $('#cat_id').change(function(){
                            var id=$(this).val();
                            $.ajax({
                                    url: "adnroid/subject_forassign.php", 
               method: "post",
               data: {id : $(this).val()} 
    })
    .done(function(response) {
        $('#subj44').html(response);
        $('#subj44').html(response);
                });
                         });
                      });
                  </script>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Note :-</label>
                    <div class="col-md-6">
                      <input type="text" name="custom_note" id="" value="" class="form-control" required>
                    </div>
                  </div>
                  
                  <br>
                  
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Add Course</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          
          
          </div>
            
              <div role="tabpanel" class="tab-pane " id="listing">	  
                    
                            <table class="table table-bordered">
    <thead>
      <tr>
        <th>S. no</th>
        <th>Course</th>
        <th>Subjects</th>
        <th>Note</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $userid=base64_decode($_GET['userid']);
        $qry="select * from custom_assign_course_byadmin where cacba_user_id='$userid' order by cacba_id desc"; 
		
		$qry_result=mysqli_query($mysqli,$qry);
	 
	 $d=mysqli_fetch_all($qry_result, MYSQLI_ASSOC);
    $i=0;
    if($d){
    foreach($d as $row){
		        $id=base64_encode($row['cacba_id']);
		        //`cacba_course_id`, `cacba_subjects_ids`, `cacba_note`, `cacba_cr_date`,
		        
		    $cacba_course_id=$row['cacba_course_id'];
           $q1="SELECT *  FROM `tbl_category`   WHERE `cid` = '$cacba_course_id' " ;
            $qry_result1=mysqli_query($mysqli,$q1);
            $cacba_category_name_d=mysqli_fetch_assoc($qry_result1);
            $cacba_category_name=$cacba_category_name_d['category_name'];
            $d=$row['cacba_subjects_ids'];
           $q="SELECT GROUP_CONCAT(subject_name) as subject_name_c  FROM `subject` WHERE `id` IN ($d)" ;
            $qry_result=mysqli_query($mysqli,$q);
            $cacba_subjects_ids_name=mysqli_fetch_assoc($qry_result)['subject_name_c'];
        
        
        ?>
      <tr>
        <td><?=$row['cacba_id'];?></td>
        <td data-courseid="<?=$row['cacba_course_id'];?>"><?=$cacba_category_name ; echo '<Br>'.$row['cacba_course_id'];?></td>
        <td data-subjectsid="<?=$row['cacba_subjects_ids'];?>"><?=$cacba_subjects_ids_name; echo '<Br>'.$row['cacba_subjects_ids'];?></td>
        <td><textarea><?= $row['cacba_note'];?></textarea></td>
        
        <td><?= $row['cacba_cr_date'];?></td>
        <td>
            <!--<button type="button" class="btn  btn-sm btn-warning" onclick="window.location.href='custom_assign.php?userid=<?=$_GET['userid']?>&edit_mode=<?=$id?>'">Edit</button>-->
            <a class="btn btn-sm btn-danger" href="custom_assign.php?userid=<?=$_GET['userid'];?>&del=<?=$id;?>">Delete</a>
        </td>
      </tr>
      <?php }
    }else{
        echo "<tr><td colspan='6'>No Any course and subject assign by admin</td></tr>";
    }
	  ?>
    </tbody>
  </table>
        
              </div>
            
           
           
           
           </div>
          
          
           <?php
        //not edit mode close    
           }?>
        
        </div>
    </div>
      </div>
</div>      
        
<?php include("includes/footer.php");?>       
