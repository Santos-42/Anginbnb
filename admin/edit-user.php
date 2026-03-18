<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin/manage-users.php");
    exit();
}

$id = mysqli_real_escape_string($connect, $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_role'])) {
    $role = mysqli_real_escape_string($connect, $_POST['role']);
    
    $update = "UPDATE MsUser SET UserRole = '$role' WHERE UserID = '$id'";
    if (mysqli_query($connect, $update)) {
        echo "<script>alert('User role updated successfully!'); window.location.href='manage-users.php';</script>";
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
}

$query = "SELECT * FROM MsUser WHERE UserID = '$id'";
$result = mysqli_query($connect, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "User not found!";
    exit();
}

$base_path = '../';
$page_css = $base_path . 'assets/css/edituser.css';
include '../components/header.php';
include '../components/navbar.php';
?>

<main>
    <div class="container">
        <h1>Edit User</h1>
        <p>Manage user permission and details</p>

        <div class="user-card">
            <form action="" method="POST">
                
                <div class="detail-baris">
                    <label>Full Name</label>
                    <div class="value"><?php echo htmlspecialchars($data['UserName']); ?></div>
                </div>
                
                <div class="detail-baris">
                    <label>Email Address</label>
                    <div class="value"><?php echo htmlspecialchars($data['UserEmail']); ?></div>
                </div>
                
                <div class="choose-role">
                    <label for="role">User Role</label>
                    <select name="role" id="role">
                        <option value="Member" <?php if($data['UserRole'] == 'Member') echo 'selected'; ?>>Member</option>
                        <option value="Admin" <?php if($data['UserRole'] == 'Admin') echo 'selected'; ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" name="update_role" id="update-btn">Update Role</button>
            </form>
        </div>
        <a href="admin/manage-users.php" style="text-decoration:none;">
                    <button type="button" id="back-btn">Back to Users</button>
        </a>
    </div>
</main>

<?php include '../components/footer.php'; ?>