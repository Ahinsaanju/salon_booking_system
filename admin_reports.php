<?php
session_start();
require 'db.php';

// Total bookings today
$today = date('Y-m-d');
$todayBookings_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM appointments WHERE appointment_date='$today'");
$todayBookings = mysqli_fetch_assoc($todayBookings_res);

// --- REVENUE QUERY FIX (Using total_amount) ---
// Column name eka 'total_amount' nisa eka use karala total eka gannawa
$revenue_query = "SELECT SUM(total_amount) as total FROM appointments WHERE status='Confirmed'";
$revenue_res = mysqli_query($conn, $revenue_query);

if (!$revenue_res) {
    die("Query failed: " . mysqli_error($conn));
}

$revenue = mysqli_fetch_assoc($revenue_res);

// Pending Bookings
$pending_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM appointments WHERE status='Pending'");
$pending = mysqli_fetch_assoc($pending_res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Business Reports - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="main-content">
        <header>
            <h1>Business Analytics</h1>
            <p>Salon performance report as of <?php echo date('d M Y'); ?></p>
        </header>

        <div class="cards">
            <div class="card">
                <h3 style="color: #ff4d6d;">Today's Bookings</h3>
                <p style="font-size: 2.2rem; font-weight: bold; margin: 15px 0;">
                    <?php echo $todayBookings['total']; ?>
                </p>
                <a href="todays_appointment.php">View List</a>
            </div>

            <div class="card">
                <h3 style="color: #B51173;">Total Revenue</h3>
                <p style="font-size: 2.2rem; font-weight: bold; margin: 15px 0;">
                    Rs. <?php echo number_format($revenue['total'] ?? 0, 2); ?>
                </p>
                <p style="font-size: 0.8rem; color: #888;">Confirmed Income</p>
            </div>

            <div class="card">
                <h3 style="color: #6c757d;">Pending Status</h3>
                <p style="font-size: 2.2rem; font-weight: bold; margin: 15px 0;">
                    <?php echo $pending['total']; ?>
                </p>
                <a href="admin_appointments.php" style="background: #6c757d;">Check Now</a>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <a href="admin_dashboard.php" class="btn-cancel" style="display:inline-block; padding: 12px 30px;">
                Back to Dashboard
            </a>
            <button onclick="window.print()" class="submit-btn" style="width: auto; padding: 12px 30px; margin-left: 10px;">
                Print Report
            </button>
        </div>
    </div>

</body>
</html>