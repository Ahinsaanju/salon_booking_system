<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<section class="login-page-wrapper">
   <div class="login-container">
        
        <?php if (isset($_GET['error'])): ?>
            <p style="color: #ff4d4d; font-weight: bold; text-align: center; background: #ffe6e6; padding: 10px; border-radius: 5px;">
                <?php 
                    if($_GET['error'] == 'wrong_password') echo "wrong password";
                    elseif($_GET['error'] == 'user_not_found') echo "wrong email";
                    else echo "Invalid Login. Please try again!";
                ?>
            </p>
        <?php endif; ?>

        <form action="login_process.php" method="POST" class="login-form">
            <h2>Login Now</h2>
            <p>Welcome! Please enter your details.</p>
            
            <div class="input-group">
                <label for="username">Email Address</label>
                <input type="email" name="username" id="username" placeholder="Enter your email" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <div class="options">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" name="login" class="login-btn">Login</button>
            
            <p class="register-link">Don't have an account? <a href="signup_form.php">Sign Up</a></p>
        </form>
    </div>
</section>    

</body>
</html>