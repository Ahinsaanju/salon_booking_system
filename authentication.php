<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location:loginform.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>