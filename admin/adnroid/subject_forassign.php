<?php
include("db.php");

if($_POST['id']!='')
{
$id=$_POST['id'];

 $query="select * from subject where course_id='$id'";

    $html='';
  //  $html.='<option value="">Select Subject</option>';
    $result = mysqli_query($con, $query);

    $d=mysqli_fetch_all($result, MYSQLI_ASSOC);
    $i=0;
    if($d){
    // $html.='<option value="ALL">All</option>';
    
    foreach($d as $record)
    //while($record=mysqli_fetch_assoc($data))
    {
    	$html.='<option value='.$record['id'].'>'.$record['subject_name'].'</option>';
    }
    }
    echo $html;
}

?>