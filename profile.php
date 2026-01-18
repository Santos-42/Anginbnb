<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$uid = $_SESSION['user_id'];
$query = mysqli_query($connect, "SELECT * FROM MsUser WHERE UserID='$uid'");
$user = mysqli_fetch_assoc($query);

$page_css = 'assets/css/profile.css';
include 'components/header.php';
include 'components/navbar.php';
?>

<main>
    <div class="container">
        <h1>My Profile</h1>
        <p>Manage your account settings and preferences</p>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div style="background:#d4edda; color:#155724; padding:15px; margin-bottom:20px; border-radius:5px;">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background:#f8d7da; color:#721c24; padding:15px; margin-bottom:20px; border-radius:5px;">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="controllers/profile_controller.php" method="POST" id="form">
            <section class="FormBox">
                <h2>Profile Information</h2>
                <div class="form-isi">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="fullname" value="<?php echo htmlspecialchars($user['UserName']); ?>" required>
                </div>
                <div class="form-isi">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['UserEmail']); ?>" required>
                </div>
                <button type="submit" name="update_info" class="save-btn">Save Changes</button>
            </section>
        </form>

        <form action="controllers/profile_controller.php" method="POST" id="form" style="margin-top:30px;">
            <section class="FormBox">
                <h2>Change Password</h2>
                <div class="form-isi">
                    <label for="CurrentPassword">Current Password</label>
                    <input type="password" id="CurrentPassword" name="current_password" required>
                </div>
                <div class="form-isi">
                    <label for="Newpass">New Password</label>
                    <input type="password" id="Newpass" name="new_password" required>
                </div>
                <div class="form-isi">
                    <label for="ConfirmPass">Confirm New Password</label>
                    <input type="password" id="ConfirmPass" name="confirm_password" required>
                </div>
                <button type="submit" name="update_password" class="save-btn">Update Password</button>
            </section>
        </form>

        <form action="controllers/profile_controller.php" method="POST" id="form" style="margin-top:30px;" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone!');">
            <section class="dangerbox">
                <h2 class="dangerTitle">Danger Zone</h2>
                <div class="danger-isi">
                    <p2>Once you delete your account, there is no going back. Please be certain.</p2>
                    <button type="submit" name="delete_account" id="delete-btn">Delete My Account</button>
                </div>
            </section>
        </form>
        
    </div>
</main>

<?php include 'components/footer.php'; ?>