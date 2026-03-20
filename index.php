<?
session_start();
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<?php

if (isset($_SESSION['user_id'])) {
    header("Location: login_user_dashboard.php");
    exit();
}
?>
<section class="hero" id="home">
        <div class="hero-content">
        <h2>Look Gorgeous, Feel Confident</h2>
        <p class="hero-subtext">Transform your look with our professional, creative styling team.</p>
        <a href="loginform.php" class="book-btn">Book Now</a>
        </div>
     <div class="hero-image">
        <img src="images/hero-image1.png"  alt="hero image">
     </div>
        
    </section>

    <?php include 'includes/footer.php'; ?>