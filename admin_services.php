<?php
session_start();
require 'db.php';

// Services list 
$result = mysqli_query($conn, "SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="booking-container" style="margin-top: 30px;">
        <h2>Manage Services</h2>
        <form method="POST" action="add_service.php">
            <div class="form-group">
                <label>Service Name</label>
                <input type="text" name="service_name" placeholder="E.g. Hair Cut" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" placeholder="Description" required>
            </div>

            <div class="form-group">
                <label>Service Price (Rs.)</label>
                <input type="text" name="price" id="servicePrice" onkeyup="checkPrice()" required>
                <span id="priceError" style="font-size: 12px; display: block;"></span>
            </div>

            <div class="form-group">
                <label>Duration (mins)</label>
                <input type="number" name="duration" placeholder="Duration" required>
            </div>

            <button type="submit" class="submit-btn">Add Service</button>
        </form>
    </div>

    <div class="bookings-main-container">
        <h2>Existing Services</h2>
        <div class="table-wrapper">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['service_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>Rs. <?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['duration']; ?> mins</td>
                        <td>
                            <a href="edit_service.php?id=<?php echo $row['service_id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete_service.php?id=<?php echo $s['service_id']; ?>" 
                            class="btn-delete" 
                            onclick="confirmServiceDelete(event, this.href)">
                            <i class="fa-solid fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
        <a href="admin_dashboard.php" class="btn-cancel" style="display:inline-block;">Back to Dashboard</a>
    </div>
<script>
// 1. Service එක Delete කරන්න කලින් අහන එක
function confirmServiceDelete(event, url) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "මෙම සේවාව (Service) පද්ධතියෙන් ඉවත් කිරීමට අවශ්‍යද?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Delete නිසා රතු පාට දාමු
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

// 2. Price එකට අකුරු දානවද බලන එක
function checkPrice() {
    let priceInput = document.getElementById('servicePrice');
    let error = document.getElementById('priceError');
    let val = priceInput.value;

    if (isNaN(val)) {
        error.innerText = "Please enter numbers only!";
        error.style.color = "red";
        priceInput.style.borderColor = "red";
    } else {
        error.innerText = "";
        priceInput.style.borderColor = "#ccc";
    }
}
</script>
</body>
</html>