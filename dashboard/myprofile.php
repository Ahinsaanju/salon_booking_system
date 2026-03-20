<?php
require '../db.php'; 

if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];
$message = "";

// Update Logic
if (isset($_POST['update'])) {
    $f_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $l_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $update_query = "UPDATE users SET first_name='$f_name', last_name='$l_name', email='$email', phone='$phone' WHERE user_id='$user_id'";
    
    if (mysqli_query($conn, $update_query)) {
        $message = "Profile updated successfully!";
    }
}

// Fetch Data
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile</title>
<link rel="stylesheet" href="../style.css">

</head>
<body>

<header><h1>BeautiSlot</h1></header>

<div class="profile-wrapper">
    <div class="profile-card">
        <form id="profileForm" action="" method="POST">
            <div class="profile-header">
                <h2>User Profile</h2>
                <span class="role-badge"><?php echo htmlspecialchars($user['role']); ?></span>
            </div>

            <?php if($message): ?>
                <p id="msg"><?php echo $message; ?></p>
            <?php endif; ?>

            <div class="profile-body">
                <div class="info-row">
                    <label>First Name</label>
                    <input type="text" name="first_name" id="f_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" disabled>
                </div>
                <div class="info-row">
                    <label>Last Name</label>
                    <input type="text" name="last_name" id="l_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" disabled>
                </div>
                <div class="info-row">
                    <label>Email Address</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                </div>
                <div class="info-row">
                   <label>Phone Number</label>
                   <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" onkeyup="validateProfilePhone()" disabled>
                   <span id="phoneError" style="font-size: 12px; display: block; margin-top: 5px;"></span>
                </div>
            </div>

            <button type="button" id="editBtn" class="edit-btn" onclick="enableEdit()">Update Profile</button>
            <button type="submit" name="update" id="saveBtn" class="edit-btn hidden">Save Changes</button>
            <div style="margin-top: 20px; text-align: center;">
                <a href="../login_user_dashboard.php" style="color: #B51173; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function enableEdit() {
    // Enable inputs
    ['f_name','l_name','email','phone'].forEach(id => {
        document.getElementById(id).disabled = false;
    });

    // Toggle buttons
    document.getElementById('editBtn').classList.add('hidden');
    document.getElementById('saveBtn').classList.remove('hidden');

    // Hide message
    const msg = document.getElementById('msg');
    if(msg) msg.style.display = 'none';
}
function validateProfilePhone() {
    let phoneInput = document.getElementById('phone');
    let errorMsg = document.getElementById('phoneError');
    let saveBtn = document.getElementById('saveBtn');
    let val = phoneInput.value;

    // 10 number validation
    if (val.length === 10 && !isNaN(val)) {
        errorMsg.innerText = "✓ Phone number is valid";
        errorMsg.style.color = "green";
        saveBtn.disabled = false; // Save button work
    } else {
        errorMsg.innerText = "Please enter a valid 10-digit number";
        errorMsg.style.color = "red";
        saveBtn.disabled = true; // Save button block
        saveBtn.style.opacity = "0.5"; 
    }
}
</script>

</body>
</html>