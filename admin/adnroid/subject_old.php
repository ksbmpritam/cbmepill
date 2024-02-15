<?php
include("db.php");
if($_POST['id']!='')
{
    ?>
    <select name="sub_id" id="subj" class="select2" required>
                          <option value="">--Select Subject--</option>
    <?php                   
      $query=mysqli_query($con,"select * from subject where course_id='".$_POST['id']."'");
      while($row=mysqli_fetch_assoc($query)){
    ?>
        <option value="<?=$row['id'];?>"><?=$row['subject_name'];?></option>
    <?php }?>
    </select>
    <?php
}
else
{
    echo json_encode(array("status"=>"0","data"=>"Fell All Field"));
}
?>