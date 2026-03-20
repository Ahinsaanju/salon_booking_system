<?php
session_start();
require 'db.php';

$result = mysqli_query($conn, "SELECT user_id, first_name, email, phone FROM users WHERE role='customer'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="bookings-main-container">
    <h2>Registered Customers</h2>
    <table class="custom-table">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th> </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td>
            <a href="delete_customer.php?id=<?php echo $row['user_id']; ?>" 
            class="btn-delete" 
            style="color: #d33; text-decoration: none; font-weight: bold;"
            onclick="confirmCustomerDelete(event, this.href)">
            <i class="fa-solid fa-trash-can"></i> Remove Customer
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
    <br>
    <a href="admin_dashboard.php" class="btn-cancel">Back</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmCustomerDelete(event, url) {
    // Page එක refresh වීම හෝ link එකට එකපාරටම යන එක නවත්තනවා
    event.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "මෙම පාරිභෝගිකයා (Customer) පද්ධතියෙන් ඉවත් කිරීමට ඔබට සහතිකද? මෙයට අදාළ දත්ත නැවත ලබාගත නොහැකි විය හැක.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Delete නිසා රතු පාට
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Remove Customer!',
        cancelButtonText: 'No, Keep'
    }).then((result) => {
        // "Yes" එබුවොත් විතරක් delete_customer.php එකට යවනවා
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>
</body>
</html>