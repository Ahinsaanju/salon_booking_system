<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: loginform.php?redirect=booknow.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user data
$user_query = "SELECT first_name, last_name, phone FROM users WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="booking-container">
    <h2>Book Appointment</h2>

    <form method="POST" action="save_booking.php">

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" value="<?php echo $user_data['first_name']." ".$user_data['last_name']; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" id="phone" value="<?php echo $user_data['phone']; ?>" onkeyup="validatePhone()" required>
            <span id="phoneError" style="font-size: 12px; display: block; margin-top: 5px;"></span>
        </div>

        <div class="form-group">
            <label>Service</label>
            <select name="service_id" id="serviceSelect" onchange="updatePrice()" required>
                <option value="" data-price="0">-- Select Service --</option>
                <?php
                $services = mysqli_query($conn, "SELECT * FROM services");
                while($s = mysqli_fetch_assoc($services)){
                ?>
               <option value="<?php echo $s['service_id']; ?>" data-price="<?php echo $s['price']; ?>">
               <?php echo $s['service_name']; ?> (Rs <?php echo $s['price']; ?>)
               </option>
               <?php } ?>
            </select>
        </div>

        <div class="form-group" style="background: #fdf0f7; padding: 10px; border-radius: 5px; border: 1px dashed #B51173;">
            <p style="margin: 0; color: #B51173; font-weight: 600;">
                Total Amount: Rs. <span id="displayPrice">0</span>
            </p>
        </div>

        <div class="form-group">
            <label>Staff</label>
            <select name="staff" required>
                <option value="">-- Select Staff --</option>
                <?php
                $query = "SELECT s.staff_id, u.first_name, s.specialization 
                          FROM staff s 
                          JOIN users u ON s.user_id = u.user_id";
                $staff_list = mysqli_query($conn, $query);
                while($s = mysqli_fetch_assoc($staff_list)){
                ?>
                <option value="<?php echo $s['staff_id']; ?>">
                    <?php echo $s['first_name']; ?> (<?php echo $s['specialization']; ?>)
                </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <label>Time</label>
            <input type="time" name="appointment_time" required>
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <select name="payment_method" required>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
            </select>
        </div>

        
        
            <button type="submit" class="submit-btn">Book Now</button>
            <a href="login_user_dashboard.php" class="btn-cancel">Cancel</a>
      
    </form>
</div>
<script id="y1c6ux">
    
function updatePrice() {
    let select = document.getElementById("serviceSelect");
    let price = select.options[select.selectedIndex].getAttribute("data-price");
    document.getElementById("displayPrice").innerText = price ? price : 0;
}

//  Phone Number check
function validatePhone() {
    let phoneInput = document.getElementById('phone');
    let errorMsg = document.getElementById('phoneError');
    let val = phoneInput.value;

    if (val.length === 10 && !isNaN(val)) {
        errorMsg.innerText = "✓ Valid number";
        errorMsg.style.color = "green";
    } else {
        errorMsg.innerText = "Enter a valid 10-digit number";
        errorMsg.style.color = "red";
    }
}
document.getElementById("date").addEventListener("change", function() {
    let selectedDate = this.value;
    let today = new Date().toISOString().split('T')[0];
    let timeInput = document.getElementById("time");

    if(selectedDate === today) {
        let now = new Date();
        let hours = String(now.getHours()).padStart(2, '0');
        let minutes = String(now.getMinutes()).padStart(2, '0');
        timeInput.min = hours + ":" + minutes;
    } else {
        timeInput.removeAttribute("min");
    }
});
</script>
</body>
</html>
