<?php
include("includes/connection.php");
if(ISSET($_POST['book_id']))
{
    $book_id=$_POST['book_id'];
    $sql="SELECT book_title from books_master where book_id='$book_id'";
    $data=mysqli_query($mysqli,$sql) or die(mysqli_error($conn));
    while($res=mysqli_fetch_assoc($data))
    {
        echo $res['book_title'];
    }
    
    
}


?>