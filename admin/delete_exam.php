<?php
	include("includes/connection.php");
        $id=$_GET['id'];
        $query="DELETE FROM exam WHERE id ='$id'";
        $delete=mysqli_query($mysqli,$query);
        if(!$delete)
        {
        	 echo "Deletion failed";
        }
        else
        {
        	echo 'Data is Deleted Successfully !';
        	header("Location: manage_exam.php");
        }
   



?>