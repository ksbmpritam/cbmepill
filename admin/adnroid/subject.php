<?php
include("db.php");

if($_POST['id']!='')
{
$id=$_POST['id'];

$query="select * from sub_categories where category_id='$id'";

    $html='';
    $data=mysqli_query($con,$query);
    
    $i=0;
    while($record=mysqli_fetch_assoc($data))
    {
    	$html.='<option value='.$record['id'].'>'.$record['name'].'</option>';
    	$i++;
    }
    echo $html;
}

?>