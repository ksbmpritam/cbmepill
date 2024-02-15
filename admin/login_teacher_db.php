<?php
include("includes/connection.php");
session_start();

$useremail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if ($useremail == "") {

    $_SESSION['msg'] = "1";
    header("Location:index_teacher.php");
    exit;
} else if ($password == "") {
    //echo "password null";
    $_SESSION['msg'] = "2";
    header("Location:index_teacher.php");
    exit;
} else {
    $qry = "select * from users where email='" . $useremail . "' and password='" . $password . "'";

    $result = mysqli_query($mysqli, $qry);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['name_teacher'] = $row['name'];


        setcookie("user", $row['name']);
        setcookie("id", $row['id']);
        header("Location:home_teacher.php");
        exit;
    } else {
        echo "not available";
        $_SESSION['msg'] = "4";
        header("Location:index_teacher.php");
        exit;
    }
}
