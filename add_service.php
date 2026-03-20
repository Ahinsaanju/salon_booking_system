<?php
require 'db.php';

// User input karana data "escape" 
$name = mysqli_real_escape_string($conn, $_POST['service_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$duration = mysqli_real_escape_string($conn, $_POST['duration']);


$sql = "INSERT INTO services (service_name, description, price, duration) 
        VALUES ('$name', '$description', '$price', '$duration')";

if (mysqli_query($conn, $sql)) {
    header("Location: admin_services.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>