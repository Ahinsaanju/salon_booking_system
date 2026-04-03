<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Salon Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

               <div class="input-group" style="position: relative;">
                    <label>Password</label>
                  <input type="password" id="password" name="password" onkeyup="validatePassword()" required>

                    <i class="fa-solid fa-eye" id="eye1"
                    onclick="togglePassword('password', 'eye1')"
                    style="position:absolute; right:10px; top:32px; cursor:pointer;">
                    </i>
                </div>

                <div class="input-group" style="position: relative;">
                    <label>Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" onkeyup="validatePassword()" required>

                    <i class="fa-solid fa-eye" id="eye2"
                    onclick="togglePassword('confirm_password', 'eye2')"
                    style="position:absolute; right:10px; top:32px; cursor:pointer;">
                    </i>
                    <span id="passwordError" style="font-size: 13px; margin-top: 5px; display: block;"></span>
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
function togglePassword(fieldId, iconId) {
    let field = document.getElementById(fieldId);
    let icon = document.getElementById(iconId);

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        field.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
function validatePassword() {
    let passwordField = document.getElementById('password');
    let confirmField = document.getElementById('confirm_password');
    let errorMsg = document.getElementById('passwordError');
    let submitBtn = document.querySelector('.login-btn');

    let passValue = passwordField.value;
    let confirmValue = confirmField.value;

    // 1. Minimum Length Check (Characters 8ක් තියෙන්න ඕනේ)
    if (passValue.length > 0 && passValue.length < 6) {
        errorMsg.innerText = "× Password must be at least 6 characters long.";
        errorMsg.style.color = "red";
        passwordField.style.borderColor = "red";
        submitBtn.disabled = true;
        submitBtn.style.opacity = "0.6";
        return; // දිග මදි නම් මෙතනින් එහාට check කරන්නේ නැහැ
    } else {
        passwordField.style.borderColor = "#ccc"; // දිග හරිනම් border එක normal කරනවා
    }

    // 2. Matching Check
    if (confirmValue.length === 0) {
        errorMsg.innerText = "";
        confirmField.style.borderColor = "#ccc";
        return;
    }

    if (passValue === confirmValue) {
        errorMsg.innerText = "✓ Passwords match and length is valid";
        errorMsg.style.color = "green";
        confirmField.style.borderColor = "green";
        submitBtn.disabled = false;
        submitBtn.style.opacity = "1";
    } else {
        errorMsg.innerText = "× Passwords do not match";
        errorMsg.style.color = "red";
        confirmField.style.borderColor = "red";
        submitBtn.disabled = true;
        submitBtn.style.opacity = "0.6";
    }
}
// Password field eka change karaddi confirm field ekath check wenna oni nisa 
// password field ekatath 'onkeyup="validatePassword()"' danna HTML eke.
</script>
</body>
</html>