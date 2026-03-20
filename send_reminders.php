<?php
require_once 'db.php';


$query = "SELECT a.appointment_id, u.first_name, u.phone, a.appointment_time 
          FROM appointments a
          JOIN users u ON a.customer_id = u.user_id
          WHERE a.reminder_sent = 0 
          AND a.status = 'Confirmed'
          AND a.appointment_date = CURDATE()
          AND TIMESTAMP(a.appointment_date, a.appointment_time) <= (NOW() + INTERVAL 1 HOUR)";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['first_name'];
    $phone = $row['phone'];
    $time = $row['appointment_time'];

    
    $message = "Hi $name, your salon appointment is at $time. See you soon!";
    
    
    echo "Reminder sent to $name ($phone) for appointment at $time <br>";

    
    $update_id = $row['appointment_id'];
    mysqli_query($conn, "UPDATE appointments SET reminder_sent = 1 WHERE appointment_id = $update_id");
}
?>