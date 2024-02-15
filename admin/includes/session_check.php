<?php
    //   ini_set('display_errors', 1);
    //   ini_set('display_startup_errors', 1);
    //   error_reporting(E_ALL);
      
      
      if (isset($_COOKIE["id"])) {
        $userValue = $_COOKIE["id"];
        // echo "Value of 'id' cookie: " . $userValue;
        } else {
           	header( "Location:logout_teacher.php");
        }
	
?>