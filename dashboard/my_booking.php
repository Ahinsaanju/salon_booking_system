<?php
session_start();
require "../db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../loginform.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Cancel Logic
if (isset($_POST['cancel_booking'])) {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['appointment_id']);
    $update_sql = "UPDATE appointments SET status='Cancelled' 
                   WHERE appointment_id='$appointment_id' AND customer_id='$user_id'";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Booking Cancelled!'); window.location='my_bookings.php';</script>";
    }
}

$sql = "SELECT appointments.appointment_id, appointments.appointment_date,
               appointments.appointment_time, appointments.status,
               appointments.total_amount, appointments.reminder_sent, services.service_name
        FROM appointments
        JOIN appointment_services ON appointments.appointment_id = appointment_services.appointment_id
        JOIN services ON appointment_services.service_id = services.service_id
        WHERE appointments.customer_id='$user_id'
        ORDER BY appointments.appointment_date DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings | Salon</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="bookings-main-container">
    <h2><i class="fa-solid fa-calendar-check"></i> My Appointments</h2>

    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Reminder Status</th> <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): 
                    $status = strtolower($row['status']);
                    $pill_class = "pill-pending";
                    if($status == 'confirmed') $pill_class = "pill-confirmed";
                    if($status == 'cancelled') $pill_class = "pill-cancelled";
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['service_name']); ?></strong></td>
                    
                    <td>
                        <small><?php echo $row['appointment_date']; ?></small><br>
                        <small><?php echo $row['appointment_time']; ?></small>
                    </td>

                    <td><span class="status-pill <?php echo $pill_class; ?>"><?php echo $row['status']; ?></span></td>

                    <td>
                        <?php if(isset($row['reminder_sent']) && $row['reminder_sent'] == 1): ?>
                            <span class="status-pill pill-confirmed">Reminder Sent</span>
                        <?php else: ?>
                            <span class="status-pill pill-pending">Pending</span>
                        <?php endif; ?>
                    </td>

                    <td style="color: #B51173; font-weight: bold;">
                        Rs. <?php echo number_format($row['total_amount'], 2); ?>
                    </td>

                    <td>
                        <?php if($status != 'cancelled'): ?>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel?');">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                <button type="submit" name="cancel_booking" class="cancel-action-btn" onclick="return confirmCancel(event)">Cancel</button>
                            </form>
                        <?php else: ?>
                            <span style="color: #999; font-size: 11px;">Already Cancelled</span>
                        <?php endif; ?>
                    </td>
                </tr>
                                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="../login_user_dashboard.php" style="color: #B51173;"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</div>
<script>
function confirmDelete(event, url) {
    event.preventDefault(); // Meka dammama button eka click karapu gaman link ekata yanne na

    Swal.fire({
        title: 'Are you sure?',
        text: "Meka cancel karanna owada?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B51173', 
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            // User "Yes" click kaloth vitharak link ekata yanawa
            window.location.href = url;
        }
    })
}
</script>
</body>
</html>