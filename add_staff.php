<?php
require 'db.php';


$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$spec = mysqli_real_escape_string($conn, $_POST['specialization']);


$sql = "INSERT INTO staff (user_id, specialization) VALUES ('$user_id', '$spec')";

if (mysqli_query($conn, $sql)) {
    header("Location: admin_staff.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>