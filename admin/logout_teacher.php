<?php
error_reporting(E_ALL ^ E_WARNING); 
session_start();
unset($_SESSION["adminuser"]);
session_destroy();
header("Location:index_teacher.php");
// echo "<script language=javascript>location.href='index.php';</script>";
?>