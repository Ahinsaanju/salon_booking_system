<?php
session_start();
require 'db.php';

// SQL Query: Join users and staff to get names
$query = "SELECT a.appointment_id, u.first_name AS customer_name, st_u.first_name AS staff_name, 
          a.appointment_date, a.appointment_time, a.status, a.total_amount 
          FROM appointments a
          JOIN users u ON a.customer_id = u.user_id 
          LEFT JOIN staff s ON a.staff_id = s.staff_id
          LEFT JOIN users st_u ON s.user_id = st_u.user_id
          ORDER BY a.appointment_date DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="bookings-main-container">
        <header style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-family: Lucida Calligraphy; color: #B51173;">BeautiSlot</h1>
            <h2 style="color: #333;">Customer Appointments</h2>
        </header>

        <div class="table-wrapper">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Staff Member</th>
                        <th>Date & Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { 
                        $statusClass = strtolower($row['status']); 
                    ?>
                    <tr>
                        <td style="font-weight: 500;"><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo $row['staff_name'] ? htmlspecialchars($row['staff_name']) : '<i style="color:gray;">Not Assigned</i>'; ?></td>
                        <td><?php echo $row['appointment_date'] . " | " . $row['appointment_time']; ?></td>
                        <td style="font-weight: bold; color: #B51173;">Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                        <td>
                            <span class="status-pill pill-<?php echo $statusClass; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Confirmed" 
                                   class="btn-confirm" 
                                   style="color: #28a745; text-decoration: none; font-weight: bold;"
                                   onclick="confirmAppointment(event, this.href)">
                                   <i class="fa-solid fa-check-circle"></i> Confirm
                                </a>

                                <a href="update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Cancelled" 
                                   class="btn-cancel" 
                                   style="color: #dc3545; text-decoration: none; font-weight: bold;"
                                   onclick="cancelAppointment(event, this.href)">
                                   <i class="fa-solid fa-times-circle"></i> Cancel
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="admin_dashboard.php" style="color: #B51173; text-decoration: none; font-weight: bold;">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

<script>
// 1. Appointment Confirm JS
function confirmAppointment(event, url) {
    event.preventDefault();
    Swal.fire({
        title: 'Confirm Appointment?',
        text: "මෙම ඇපොයින්ට්මන්ට් එක ස්ථිර (Confirm) කිරීමට අවශ්‍යද?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Confirm it!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

// 2. Appointment Cancel JS
function cancelAppointment(event, url) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "මෙම ඇපොයින්ට්මන්ට් එක අවලංගු (Cancel) කිරීමට ඔබට සහතිකද?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Cancel it!',
        cancelButtonText: 'Keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

</body>
</html>