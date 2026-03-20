<?php
session_start();
require 'db.php';

// Access control
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: loginform.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];

// Fetch appointments (optional: you can use this to show a count or latest booking)
$sql = "SELECT * FROM appointments WHERE customer_id='$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>User Dashboard</title>

<link rel="stylesheet" href="style.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>
 <header>
        <h1>BeautiSlot</h1>    
</header>

<div class="dashboard-container">

<div class="sidebar">

<ul>

<li><a href="#" class="active">Dashboard</a></li>

<li><a href="booknow.php">Book Appointment</a></li>

<li><a href="/finalproject/dashboard/my_booking.php">My Bookings</a></li>

<li><a href="/finalproject/dashboard/myprofile.php">Profile</a></li>

<li><a href="logout.php">Logout</a></li>

</ul>

</div>

<div class="main-content">

<header>

<h1>Welcome <?php echo $_SESSION['first_name'] ?? 'User'; ?> !</h1>

<p>Manage your salon appointments easily</p>

</header>

<div class="cards">

<div class="card">
<h3>Book Appointment</h3>
<p>Schedule your next salon visit.</p>
<a href="booknow.php">Book Now</a>
</div>

<div class="card">
<h3>My Bookings</h3>
<p>Check your appointment history.</p>
<a href="/finalproject/dashboard/my_booking.php">View</a>
</div>

<div class="card">
<h3>Profile</h3>
<p>Update your personal details.</p>
<a href="/finalproject/dashboard/myprofile.php">Manage</a>
</div>

</div>

</div>

</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>