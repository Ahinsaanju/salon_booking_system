<?php
require_once 'db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT * FROM services WHERE service_id=$id");
    $service = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])) {
    $id = $_POST['service_id'];
    $name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $sql = "UPDATE services 
            SET service_name='$name', 
                description='$description', 
                price='$price', 
                duration='$duration' 
            WHERE service_id=$id";

    if(mysqli_query($conn, $sql)) {
        header("Location: admin_services.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="booking-container">
    <h2>Edit Service</h2>

    <form method="POST">
        <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">

        <div class="form-group">
            <label>Service Name</label>
            <input type="text" name="service_name" value="<?php echo $service['service_name']; ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" value="<?php echo $service['description']; ?>" required>
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="text" name="price" value="<?php echo $service['price']; ?>" required>
        </div>

        <div class="form-group">
            <label>Duration (minutes)</label>
            <input type="text" name="duration" value="<?php echo $service['duration']; ?>" required>
        </div>

        <button type="submit" name="update" class="submit-btn">Update Service</button>
    </form>
</div>

</body>
</html>