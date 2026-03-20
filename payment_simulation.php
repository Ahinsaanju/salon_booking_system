<?php
session_start();
require_once 'db.php'; // Database connection එක හරියටම තියෙන්න ඕන

// URL එකෙන් Appointment ID සහ Amount එක ගන්නවා
$app_id = isset($_GET['appointment_id']) ? mysqli_real_escape_string($conn, $_GET['appointment_id']) : '';
$amount = isset($_GET['amount']) ? mysqli_real_escape_string($conn, $_GET['amount']) : '0';

$alert_type = ""; 
$last_digits = "";

if(isset($_POST['pay_now'])) {
    $card_no = $_POST['card_number'];
    $cvv = $_POST['cvv'];

    // Validation - Card number 
    if(strlen($card_no) == 16 && strlen($cvv) == 3) {
        
        // 1. Appointments Table  status updated to 'Confirmed' 
        $update_apt_sql = "UPDATE appointments SET 
                            status = 'Confirmed', 
                            payment_status = 'Paid', 
                            payment_method = 'Online Card' 
                           WHERE appointment_id = '$app_id'";
        
        // 2.add new record to Payments Table  
        $insert_pay_sql = "INSERT INTO payments (appointment_id, payment_method, payment_status, amount) 
                           VALUES ('$app_id', 'Online Card', 'Success', '$amount')";

        //  success message 
        if(mysqli_query($conn, $update_apt_sql) && mysqli_query($conn, $insert_pay_sql)) {
            $alert_type = "success";
            $last_digits = substr($card_no, -4);
        } else {
            // Database Error 
            $alert_type = "db_error";
            $db_error_msg = mysqli_error($conn);
        }
    } else {
        $alert_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Simulation | Salon System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffe6f0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .payment-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-top: 6px solid #ff66a3;
        }

        .card-icon-container { font-size: 60px; margin-bottom: 10px; }
        .payment-box h2 { color: #B51173; margin-bottom: 10px; }
        .input-group { text-align: left; margin-bottom: 15px; }
        .input-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px; color: #444; }
        .input-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1.5px solid #ffd6e0; 
            border-radius: 8px; 
            box-sizing: border-box; 
            outline: none;
        }
        .input-group input:focus { border-color: #ff66a3; }
        .payment-row { display: flex; gap: 15px; }
        .pay-now-btn { 
            width: 100%; 
            padding: 14px; 
            background: #ff66a3; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-size: 16px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s; 
            margin-top: 10px; 
        }
        .pay-now-btn:hover { background: #B51173; }
        .btn-cancel { display: block; margin-top: 15px; color: #666; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<div class="payment-wrapper">
    <div class="payment-box">
        <div class="card-icon-container">💳</div>
        <h2>Online Payment</h2>
        <p>Complete your booking for <b>Rs <?php echo number_format($amount, 2); ?></b></p>
        
        <form method="POST">
            <div class="input-group">
                <label>Card Number</label>
                <input type="text" name="card_number" placeholder="1234567890123456" maxlength="16" required>
            </div>

            <div class="payment-row">
                <div class="input-group" style="flex: 2;">
                    <label>Expiry Date</label>
                    <input type="text" placeholder="MM/YY" maxlength="5" required>
                </div>
                <div class="input-group" style="flex: 1;">
                    <label>CVV</label>
                    <input type="text" name="cvv" placeholder="123" maxlength="3" required>
                </div>
            </div>

            <button type="submit" name="pay_now" class="pay-now-btn">Confirm & Pay Now</button>
            <a href="dashboard/my_booking.php" class="btn-cancel">Cancel Payment</a>
        </form>
    </div>
</div>

<script>
// SweetAlert use to shoe alert
<?php if($alert_type == "success"): ?>
    Swal.fire({
        title: 'Payment Successful!',
        text: 'ගෙවීම සාර්ථකයි! Card අංකයේ අවසාන ඉලක්කම්: <?php echo $last_digits; ?>',
        icon: 'success',
        confirmButtonColor: '#B51173',
        confirmButtonText: 'Go to My Bookings'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'dashboard/my_booking.php';
        }
    });
<?php elseif($alert_type == "error"): ?>
    Swal.fire({
        title: 'Invalid Details!',
        text: 'කරුණාකර නිවැරදි Card අංකයක් සහ CVV එකක් ඇතුළත් කරන්න.',
        icon: 'error',
        confirmButtonColor: '#ff66a3'
    });
<?php elseif($alert_type == "db_error"): ?>
    Swal.fire({
        title: 'Database Error!',
        text: 'Error: <?php echo $db_error_msg; ?>',
        icon: 'warning'
    });
<?php endif; ?>
</script>

</body>
</html>