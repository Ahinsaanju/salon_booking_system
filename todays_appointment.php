<?php
include 'db.php';

// get today's date
$today = date("Y-m-d");

// fetch today's appointments
$sql = "SELECT * FROM appointments WHERE appointment_date = '$today' ORDER BY appointment_time ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Today's Appointments</title>
    <style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f8e9ee; /* light pink background */
    margin: 0;
    padding: 20px;
}

/* Main container */
.container {
    width: 90%;
    margin: auto;
    background: #f3dbe1;
    padding: 20px;
    border-radius: 15px;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #e6b8c4;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.logo {
     font-family: Lucida Calligraphy;
     font-weight: 600;
     color: #B51173;
     font-size: 30px;
}

.title {
    font-size: 20px;
    font-weight: 600;
    color: #333;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    background: #f7d5de;
    border-radius: 10px;
    overflow: hidden;
}

/* Header row */
th {
    background-color: #e4a9b7;
    color: #b0005a;
    padding: 12px;
    font-size: 20px;
    text-align: left;
}

/* Table cells */
td {
    padding: 14px;
    border-bottom: 1px solid #eac3cc;
}

/* Hover effect */
tr:hover {
    background-color: #fbe4ea;
}

/* Amount styling */
td:nth-child(4) {
    color: #c2185b;
    font-weight: bold;
}

/* Status badges */
.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

/* Status colors */
.confirmed {
    background-color: #c8e6c9;
    color: #2e7d32;
}

.pending {
    background-color: #ffe0b2;
    color: #ef6c00;
}

.cancelled {
    background-color: #ffcdd2;
    color: #c62828;
}

/* Buttons */
.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

/* Confirm button */
.btn-confirm {
    background-color: #4caf50;
    color: white;
}

/* Cancel button */
.btn-cancel {
    background-color: #6c757d;
    color: white;
    margin-left: 10px;
}

/* Icons spacing */
.action {
    display: flex;
    align-items: center;
    gap: 10px;
}
</style>
</head>
<body>

<div class="container">

    <div class="header">
        <div class="logo">BeautiSlot</div>
        <div class="title">Today's Appointments</div>
    </div>

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Service</th>
        <th>Time</th>
        <th>Status</th>
    </tr>

    <?php
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
    ?>
    <tr>
        <td><?php echo $row['customer_name']; ?></td>
        <td><?php echo $row['service']; ?></td>
        <td><?php echo $row['appointment_time']; ?></td>
        <td>
        <?php
        $status = strtolower($row['status']);
        echo "<span class='status $status'>" . ucfirst($row['status']) . "</span>";
        ?>
        </td>
    </tr>
    <?php
        }
    } else {
        echo "<tr><td colspan='4'>No appointments today</td></tr>";
    }
    ?>

</table>

</body>
</html>