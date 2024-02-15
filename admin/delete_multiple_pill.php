<?php
require ("includes/function.php");

if(isset($_POST['checkbox'][0])){
	foreach($_POST['checkbox'] as $list){
		$id=mysqli_real_escape_string($mysqli,$list);
		mysqli_query($mysqli,"delete from pills where id='$id'");
	}
}

?>