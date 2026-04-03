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
            <label>Date</label>
            <input type="date" id="date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <label>Time</label>
            <select id="time" name="appointment_time" required>
                <option value="">-- Select Time --</option>
            </select>
        </div>

        <div class="form-group">
            <label>Staff</label>
            <select name="staff" id="staffSelect" required>
                <option value="">-- Select Staff --</option>
            </select>
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

<script>
function updatePrice() {
    let select = document.getElementById("serviceSelect");
    let price = select.options[select.selectedIndex].getAttribute("data-price");
    document.getElementById("displayPrice").innerText = price ? price : 0;
}

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

// Generate time slots
function generateTimeSlots(selectedDate) {
    let timeSelect = document.getElementById("time");
    let today = new Date().toISOString().split('T')[0];
    timeSelect.innerHTML = '<option value="">-- Select Time --</option>';

    let startHour = 9;
    let endHour = 20;
    let now = new Date();

    for (let h = startHour; h <= endHour; h++) {
        for (let m = 0; m < 60; m += 30) {
            let hour = String(h).padStart(2,'0');
            let minute = String(m).padStart(2,'0');
            let timeValue = hour + ":" + minute;

            if (selectedDate === today) {
                let slotTime = new Date();
                slotTime.setHours(h, m, 0);
                if (slotTime <= now) continue;
            }

            let option = document.createElement("option");
            option.value = timeValue;
            option.textContent = timeValue;
            timeSelect.appendChild(option);
        }
    }
}

// Fetch available staff
function fetchAvailableStaff() {
    let serviceId = document.getElementById("serviceSelect").value;
    let date = document.getElementById("date").value;
    let time = document.getElementById("time").value;

    if (!serviceId || !date || !time) return; // if not selected, stop

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "get_available_staff.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (this.status === 200) {
            let staffSelect = document.getElementById("staffSelect");
            staffSelect.innerHTML = '<option value="">-- Select Staff --</option>';
            let staffList = JSON.parse(this.responseText);
            staffList.forEach(staff => {
                let option = document.createElement("option");
                option.value = staff.staff_id;
                option.textContent = staff.first_name + " (" + staff.specialization + ")";
                staffSelect.appendChild(option);
            });
        }
    };
    xhr.send(`service_id=${serviceId}&date=${date}&time=${time}`);
}

// Call fetchAvailableStaff whenever service, date, or time changes
document.getElementById("serviceSelect").addEventListener("change", fetchAvailableStaff);
document.getElementById("date").addEventListener("change", function() {
    generateTimeSlots(this.value);
    fetchAvailableStaff();
});
document.getElementById("time").addEventListener("change", fetchAvailableStaff);
window.onload = function() {
    generateTimeSlots(document.getElementById("date").value);
    fetchAvailableStaff(); // add this line
};
</script>
</body>
</html>
