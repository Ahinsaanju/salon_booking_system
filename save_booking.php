<?php
session_start();
require_once 'db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: loginform.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $customer_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $payment_method = $_POST['payment_method'];
    $staff_id = $_POST['staff'];

    // 🔴 BASIC VALIDATION
    if(empty($service_id) || empty($staff_id)) {
        echo "<script>alert('Please select service and staff'); window.history.back();</script>";
        exit();
    }

    $today = date("Y-m-d");
    $current_time = date("H:i"); // ✅ FIXED

    // ❌ Past date check
    if($appointment_date < $today) {
        echo "<script>alert('You cannot select a past date!'); window.history.back();</script>";
        exit();
    }

    // ❌ Time range check (Salon hours)
    if($appointment_time < "09:00" || $appointment_time > "18:00") {
        echo "<script>alert('Select time between 9AM - 6PM'); window.history.back();</script>";
        exit();
    }

    // ❌ Past time check (if today)
    if($appointment_date == $today && $appointment_time <= $current_time) {
        echo "<script>alert('You cannot select a past time!'); window.history.back();</script>";
        exit();
    }

    // 🔥 CHECK TIME CONFLICT (IGNORE CANCELLED)
    $check_sql = "SELECT appointment_id FROM appointments 
                  WHERE appointment_date=? 
                  AND appointment_time=? 
                  AND staff_id=? 
                  AND status != 'Cancelled'";

    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "ssi", $appointment_date, $appointment_time, $staff_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0) {
        echo "<script>alert('This staff is already booked for this time!'); window.history.back();</script>";
        exit();
    }

    // 💰 GET SERVICE PRICE (prepared)
    $price_sql = "SELECT price FROM services WHERE service_id=?";
    $stmt_price = mysqli_prepare($conn, $price_sql);
    mysqli_stmt_bind_param($stmt_price, "i", $service_id);
    mysqli_stmt_execute($stmt_price);
    $price_result = mysqli_stmt_get_result($stmt_price);
    $service = mysqli_fetch_assoc($price_result);

    $total_amount = $service['price'];

    // 🔥 INSERT APPOINTMENT
    $sql = "INSERT INTO appointments 
        (customer_id, staff_id, appointment_date, appointment_time, status, payment_status, payment_method, total_amount) 
        VALUES (?, ?, ?, ?, 'Pending', 'Pending', ?, ?)";

    $stmt2 = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt2, "iisssd", $customer_id, $staff_id, $appointment_date, $appointment_time, $payment_method, $total_amount);

    if(mysqli_stmt_execute($stmt2)) {

        $appointment_id = mysqli_insert_id($conn);

        // 🔥 INSERT SERVICE
        $sql3 = "INSERT INTO appointment_services (appointment_id, service_id) VALUES (?, ?)";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "ii", $appointment_id, $service_id);
        mysqli_stmt_execute($stmt3);

        // 💳 PAYMENT LOGIC
        if($payment_method == 'Card') {
            header("Location: payment_simulation.php?appointment_id=" . $appointment_id . "&amount=" . $total_amount);
            exit();
        } else {
            echo "<script>alert('Appointment Booked Successfully! Please pay at the salon.'); window.location='login_user_dashboard.php';</script>";
            exit();
        }

    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>