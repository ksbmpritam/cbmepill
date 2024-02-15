<?php
	include("includes/connection.php");
        $id=$_GET['id'];
        $query="DELETE FROM books_master WHERE id ='$id'";
        $delete=mysqli_query($mysqli,$query);
        if(!$delete)
        {
        	 echo "Deletion failed";
        }
        else
        {
        	echo 'Data is Deleted Successfully !';
        	header("Location: books_master.php");
        }
   



?>