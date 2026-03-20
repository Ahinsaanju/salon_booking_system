<?php
require 'db.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM services WHERE service_id=$id");

header("Location: admin_services.php");
?>