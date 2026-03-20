<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Salon Booking</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <section class="login-page-wrapper">
        <div class="signup-container">
            <form class="signup-form" method="POST" action="signup_process.php">
                <h2>Create Account</h2>
                <p>Join our salon to book your next glow-up!</p>

                <div class="input-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" required>
                </div>

                <div class="input-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" required>
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" id="phone" 
                        placeholder="07XXXXXXXX" 
                        maxlength="10" 
                        onkeyup="validatePhone()" required>
                    <span id="phoneError" style="font-size: 13px; margin-top: 5px; display: block;"></span>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <button type="submit" name="signup" class="login-btn">Sign Up</button>

                <p class="register-link">
                    Already have an account? <a href="loginform.php">Login here</a>
                </p>
            </form> 
        </div>
    </section>
    <script>
function validatePhone() {
    let phoneInput = document.getElementById('phone');
    let errorMsg = document.getElementById('phoneError');
    let phoneValue = phoneInput.value;

    // 1. Number eka digits 10k da kiyala balanna
    if (phoneValue.length === 10) {
        // Number eka hari nam
        errorMsg.innerText = "✓ Valid phone number";
        errorMsg.style.color = "green";
        phoneInput.style.borderColor = "green";
    } else if (phoneValue.length > 10) {
        // 10kata wadi nam
        errorMsg.innerText = "Too long! Only 10 digits allowed.";
        errorMsg.style.color = "red";
        phoneInput.style.borderColor = "red";
    } else {
        // 10kata adu nam (type karana gaman)
        errorMsg.innerText = "Enter 10 digits (Current: " + phoneValue.length + ")";
        errorMsg.style.color = "orange";
        phoneInput.style.borderColor = "orange";
    }

    // 2. Number nathi characters (letters) thiyeda balanna
    if (isNaN(phoneValue)) {
        errorMsg.innerText = "Numbers only, please!";
        errorMsg.style.color = "red";
    }
}
</script>
</body>
</html>