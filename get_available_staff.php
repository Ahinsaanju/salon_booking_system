<?php
require_once 'db.php';

// Check if POST data exists
if (!isset($_POST['service_id'], $_POST['date'], $_POST['time'])) {
    echo json_encode([]); // return empty array
    exit();
}

$service_id = $_POST['service_id'];
$date = $_POST['date'];
$time = $_POST['time'];

// Get available staff
$query = "SELECT s.staff_id, u.first_name, s.specialization
FROM staff s
JOIN users u ON s.user_id = u.user_id
WHERE s.staff_id NOT IN (
    SELECT staff_id FROM appointments 
    WHERE appointment_date = '$date'
    AND appointment_time = '$time'
    AND status != 'Cancelled'
)";

$result = mysqli_query($conn, $query);

$staffList = [];

while($row = mysqli_fetch_assoc($result)) {
    $staffList[] = $row;
}

echo json_encode($staffList);
?>