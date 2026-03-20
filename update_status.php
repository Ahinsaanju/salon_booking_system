<?php
require 'db.php';

if(isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    
    // Appointment status update 
    $sql = "UPDATE appointments SET status = '$status' WHERE appointment_id = '$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_appointments.php");
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>