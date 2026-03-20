<?php
session_start();
require 'db.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    
    $sql = "DELETE FROM users WHERE user_id = $id AND role = 'customer'";

    if(mysqli_query($conn, $sql)){
        
        header("Location: admin_customers.php?msg=deleted");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>