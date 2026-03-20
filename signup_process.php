<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastname  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);
    $pass      = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. Password match check
    if ($pass !== $confirm_pass) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // 2. Check duplicate email
    $checkEmail = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('This email is already registered!'); window.history.back();</script>";
        exit();
    }

    // 3. Insert user
    $password_hashed = password_hash($pass, PASSWORD_BCRYPT);
    $role = 'customer'; 

    $sql = "INSERT INTO users (first_name, last_name, email, phone, password, role) 
            VALUES ('$firstname', '$lastname', '$email', '$phone', '$password_hashed', '$role')";

    if (mysqli_query($conn, $sql)) {
        $user_id = mysqli_insert_id($conn);

        // ✅ FIX: correct session names
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        $_SESSION['first_name'] = $firstname;

        echo "<script>alert('Signup successful!'); window.location.href='login_user_dashboard.php';</script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>