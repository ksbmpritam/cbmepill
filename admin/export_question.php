<?php  

 $con=mysqli_connect("localhost","wwwangir_angiralive","Angiralive","wwwangir_angiralive");
if(mysqli_connect_errno()){
	echo "faild to connect to mysql".mysqli_connect_errno();
}
 //  session_start();
 $query = mysqli_query($con, "SELECT * FROM question where e_id='".$_GET['downlaod']."' order by id desc");
$array= mysqli_fetch_array($query);

if($array==null || $array=="" ||$array==[]){
	echo "<script>alert('Questions Not Found. Please Upload Question')</script>";
    echo "<script>window.location.href='manage_exam.php';</script>";
    exit();
}
ob_start();

    $file="Question.xls";
    header('Content-Type: text/html');
    $table = $_POST['tablehidden'];//i get this from another php file.It is HTML table
    header("Content-type: application/x-msexcel"); //tried adding  charset='utf-8' into header
    header("Content-Disposition: attachment; filename=$file");
    echo $table;
    
if($_GET['downlaod']){?>
                             <table width="100%" cellpadding="0" cellspacing="0" class="listing">
                            <tr>
                                    <th width="70">Sl.No</th>
                                    <th width="232">Question Name</th>
                                    <th width="232">Option A</th>
                                    <th width="232">Option B</th>
                                    <th width="232">Option C</th>
                                    <th width="232">Option D</th>
                                    <th width="232">Answer</th>
                                    <th width="232">Image</th>
                                    <th width="232">ImgOption 1</th>
                                    <th width="232">ImgOption 2</th>
                                    <th width="232">ImgOption 3</th>
                                    <th width="232">ImgOption 4</th>
                                    <th width="232">Date-Time</th>
                                    
                                    
                                     
                              </tr>
                              
                              <?php 
                                 
                                    $i=1;

                                    $query = mysqli_query($con, "SELECT * FROM question where e_id='".$_GET['downlaod']."' order by id desc");

                                    while($row = mysqli_fetch_array($query))
                                    {

                                    
                                    ?>
                              
                           
                            <tr>
                            <td class="style1" align="center"><?php echo $i; ?></td>
                             <td class="style1" align="center"><?php echo $row['Question']; ?></td>
                             <td class="style1" align="center"><?php echo $row['option_1']; ?></td>
                              <td class="style1" align="center"><?php echo $row['option_2']; ?></td>
                              <td class="style1" align="center"><?php echo $row['option_3']; ?></td>
                              <td class="style1" align="center"><?php echo $row['option_4']; ?></td>
                              <td class="style1" align="center"><?php echo $row['answer']; ?></td>
                               <td class="style1" align="center"><?php echo $row['image']; ?></td>
                                <td class="style1" align="center"><?php echo $row['image_opt1']; ?></td>
                                <td class="style1" align="center"><?php echo $row['image_opt2']; ?></td>
                                <td class="style1" align="center"><?php echo $row['image_opt3']; ?></td>
                                <td class="style1" align="center"><?php echo $row['image_opt4']; ?></td>
                              <td class="style1" align="center"><?php echo $row['datetime']; ?></td>
                               
                                 
                                     
   
    <?php $i++;} }  
    
    
     ?>