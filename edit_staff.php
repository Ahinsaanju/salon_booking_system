<?php
require_once 'db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysqli_query($conn, "
        SELECT staff.*, users.first_name, users.last_name 
        FROM staff 
        JOIN users ON staff.user_id = users.user_id
        WHERE staff.staff_id=$id
    ");
    $staff = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])) {
    $id = $_POST['staff_id'];
    $specialization = $_POST['specialization'];

    $sql = "UPDATE staff SET specialization='$specialization' WHERE staff_id=$id";

    if(mysqli_query($conn, $sql)) {
        header("Location: admin_staff.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Staff</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="booking-container">
    <h2>Edit Staff</h2>

    <form method="POST">
        <input type="hidden" name="staff_id" value="<?php echo $staff['staff_id']; ?>">

        <div class="form-group">
            <label>Staff Name</label>
           <input type="text" value="<?php echo $staff['first_name'] . ' ' . $staff['last_name']; ?>" disabled>
        </div>

        <div class="form-group">
            <label>Specialization</label>
            <input type="text" name="specialization" value="<?php echo $staff['specialization']; ?>" required>
        </div>

        <button type="submit" name="update" class="submit-btn">Update Staff</button>
    </form>
</div>

</body>
</html>