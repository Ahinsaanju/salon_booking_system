<?php
session_start();
require_once '../db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$name = $_POST['name'];
$phone = $_POST['phone'];
$service = $_POST['service'];
$staff = $_POST['staff'];
$date = $_POST['date'];
$time = $_POST['time'];

$sql = "INSERT INTO appointments (user_id, name, phone, service, staff, date, time)
        VALUES ('$user_id', '$name', '$phone', '$service', '$staff', '$date', '$time')";

if(mysqli_query($conn,$sql)){
    header("Location: ../booking_success.php");
}else{
    echo "Error: " . mysqli_error($conn);
}
?>