<?php
session_start();
require_once 'db.php';

// only staff can access
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'staff')
{
    header("Location: loginform.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// get staff details
$sql = "SELECT * FROM staff WHERE user_id='$user_id'";
$result = mysqli_query($conn,$sql);
$staff = mysqli_fetch_assoc($result);

$staff_id = $staff['staff_id'];

// get appointments
$query = "SELECT a.*, u.first_name, u.phone 
          FROM appointments a
          JOIN users u ON a.customer_id = u.user_id
          WHERE a.staff_id='$staff_id'
          ORDER BY a.appointment_date DESC";

$appointments = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Staff Dashboard</title>
<link rel="stylesheet" href="style.css">

</head>

<body>
<header>
        <h1>BeautiSlot</h1>
       
</header>
<div class="staff-dashboard-container">

<h2>Staff Dashboard</h2>

<div class="stf-card">

<h3>Your Details</h3>

<p><b>Staff ID :</b> <?php echo $staff['staff_id']; ?></p>
<p><b>Specialization :</b> <?php echo $staff['specialization']; ?></p>

</div>


<div class="stf-card">

<h3>Your Appointments</h3>

<table class="staff">

<tr>
<th>Customer Name</th>
<th>Phone</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($appointments)) { ?>

<tr>
<td><?php echo $row['first_name']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['appointment_date']; ?></td>
<td><?php echo $row['appointment_time']; ?></td>
<td><?php echo $row['status']; ?></td>
</tr>

<?php } ?>

</table>

</div>

<a class="stf-logout" href="logout.php">Logout</a>

</div>

</body>
</html>