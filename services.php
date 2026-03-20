<?php 
require 'db.php'; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>


<div class="main-content">
    <div style="text-align:center; margin-bottom: 40px;">
        <h2 style="color: #B51173; font-size: 2.5rem;">Our Services</h2>
        <p style="color: #666;">Elevate your beauty with our professional touch.</p>
    </div>

    <div class="services-container">
        <?php
        $services = mysqli_query($conn, "SELECT * FROM services");
        while($s = mysqli_fetch_assoc($services)) {
        ?>
        <div class="service-card">
            <div class="service-icon">
                <i class="fa-solid fa-sparkles" style="color: #ff66a3; font-size: 2rem;"></i>
            </div>
            <h3><?php echo $s['service_name']; ?></h3>
            <p class="price-tag">Rs. <?php echo number_format($s['price'], 2); ?></p>
            <p style="font-size: 0.9rem; color: #777; margin: 15px 0;">Experience premium care with our specialized <?php echo strtolower($s['service_name']); ?> treatment.</p>
            <a href="loginform.php?service=<?php echo $s['service_id']; ?>">Book This</a>
        </div>
        <?php } ?>
    </div>
</div>

< <?php include 'includes/footer.php'; ?>

</body>
</html>