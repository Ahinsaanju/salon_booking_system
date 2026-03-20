<?php
session_start();
require 'db.php';

if($_SESSION['role'] != 'admin')
{
 header("Location: loginform.php");
 exit();
}

// counts
$staff_count = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM staff"))['total'];
$appointment_count = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM appointments"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM users WHERE role='customer'"))['total'];

// 🔥 NEW: total revenue
$revenue = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(total_amount) as total FROM appointments"))['total'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>
<link rel="stylesheet" href="admin.css">

</head>

<body>
<header>
        <h1>BeautiSlot</h1>
</header>

<div class="dashboard">

<!-- SIDEBAR -->
<div class="sidebar">
<ul>

<li><a href="admin_dashboard.php">Dashboard</a></li>

<!-- 🔥 NEW LINKS -->
<li><a href="admin_services.php">Manage Services</a></li>
<li><a href="admin_staff.php">Manage Staff</a></li>
<li><a href="admin_reports.php">Reports</a></li>
<li><a href="admin_appointments.php">Appointments</a></li>
<li><a href="admin_customers.php">Customers</a></li>

<li><a href="logout.php">Logout</a></li>

</ul>
</div>

<!-- MAIN CONTENT -->
<div class="main">

<h1>Admin Dashboard</h1>

<div class="cards">

<div class="card">
<h3>Total Staff</h3>
<p><?php echo $staff_count; ?></p>
</div>

<div class="card">
<h3>Total Appointments</h3>
<p><?php echo $appointment_count; ?></p>
</div>

<div class="card">
<h3>Total Customers</h3>
<p><?php echo $user_count; ?></p>
</div>

<!-- 🔥 NEW CARD -->
<div class="card">
<h3>Total Revenue</h3>
<p>Rs. <?php echo $revenue ? $revenue : 0; ?></p>
</div>

</div>

</div>

</div>

</body>
</html>