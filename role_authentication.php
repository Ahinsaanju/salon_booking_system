<?php
require 'authentication.php';

if($_SESSION['role'] != 'admin')
{
    header("Location:user_dashboard.php");
    exit();
}
?>