<?php
session_start();
require 'db.php';

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn, $_POST['username']); 
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1)
    {
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password']))
        {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['role'] = $user['role'];

            // 🔹 Role check
           if($user['role'] == 'admin')
        {
            header("Location: admin_dashboard.php");

         }
          elseif($user['role'] == 'staff')
         {
            header("Location: staff_dashboard.php");
         }
          else
         {
            header("Location: login_user_dashboard.php");
         }

        exit();
        }
        else
        {
            header("Location: loginform.php?error=wrong_password");
            exit();
        }
    }
    else
    {
        header("Location: loginform.php?error=user_not_found");
        exit();
    }
}
?>