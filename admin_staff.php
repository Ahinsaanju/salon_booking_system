<?php
session_start();
require 'db.php';


$query = "SELECT s.staff_id, u.first_name, u.last_name, s.specialization 
          FROM staff s 
          JOIN users u ON s.user_id = u.user_id";
$result = mysqli_query($conn, $query);


$users_list = mysqli_query($conn, "SELECT user_id, first_name, last_name FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Staff - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="booking-container">
    <h2>Add New Staff</h2>
    <form method="POST" action="add_staff.php">
        <div class="form-group">
            <label>Select User</label>
            <select name="user_id" required>
                <option value="">-- Select User --</option>
                <?php while($u = mysqli_fetch_assoc($users_list)) { ?>
                    <option value="<?php echo $u['user_id']; ?>">
                        <?php echo $u['first_name'] . " " . $u['last_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Specialization</label>
            <input type="text" name="specialization" placeholder="E.g. Hair Stylist" required>
        </div>

        <button type="submit" class="submit-btn">Add Staff Member</button>
    </form>
</div>

<div class="bookings-main-container">
    <h2>Staff List</h2>
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Specialization</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                    <td><?php echo $row['specialization']; ?></td>
                    <td>
                        
                    <a href="edit_staff.php?id=<?php echo $row['staff_id']; ?>" class="edit-btn">Edit</a>
                       <a href="delete_staff.php?id=<?php echo $s['staff_id']; ?>" 
                        class="delete-btn" 
                        onclick="confirmStaffDelete(event, this.href)">
                        <i class="fa-solid fa-user-xmark"></i> Remove Staff
                        </a>
                    </td>
                   
                      
                       
                       
</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <br>
    <a href="admin_dashboard.php" class="btn-cancel" style="display:inline-block;">Back</a>
</div>
<script>
function confirmStaffDelete(event, url) {
    // 1. එකපාරටම ලින්ක් එකට යන එක නවත්තනවා
    event.preventDefault();

    // 2. SweetAlert 
    Swal.fire({
        title: 'Are you sure?',
        text: "මෙම සේවකයා (Staff Member) පද්ධතියෙන් ඉවත් කිරීමට ඔබට සහතිකද?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Delete 
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Remove!',
        cancelButtonText: 'No, Keep'
    }).then((result) => {
        // user say yes
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>
</body>
</html>