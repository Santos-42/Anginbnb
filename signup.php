<?php 
include 'config/database.php';
$page_css = 'assets/css/signup.css'; 
include 'components/header.php'; 
include 'components/navbar.php'; 
?>

<main>
    <form action="controllers/auth_controller.php" method="POST" id="form-location" style="margin-bottom: 10px;">
        <input type="hidden" name="action" value="register">

        <div id="form-box">
            <span id="sambutan-signup">Create Your Account</span>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div style="background: #ffdddd; color: red; padding: 10px; margin-bottom: 10px; border-radius: 5px; text-align: center;">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <div class="input-form">
                <label for="fullname">Full name</label>
                <input type="text" id="fullname" name="fullname" placeholder="Input Your fullname here" value="<?php echo isset($_SESSION['old_fullname']) ? htmlspecialchars($_SESSION['old_fullname']) : ''; ?>" required>
                <span>3 - 50 characters, letters and spaces only</span>
            </div>
            
            <div class="input-form">
                <label for="emailaddress">Email address</label>
                <input type="email" id="emailaddress" name="email" placeholder="Enter Your email address here" value="<?php echo isset($_SESSION['old_email']) ? htmlspecialchars($_SESSION['old_email']) : ''; ?>" required>
            </div>
            
            <div class="input-form">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your password here" required>
                <span>At least 8 characters with uppercase, lowercase, number, and special character</span>
            </div>
            
            <button type="submit" id="submit-btn">Create Account</button>
            
            <div>
                <span id="reminder">Already have an account? <a href="login.php" id="hrefsignin">Sign in</a></span>
            </div>
        </div>
    </form>
    <?php
    unset($_SESSION['old_fullname']);
    unset($_SESSION['old_email']);
    ?>
</main>

<?php include 'components/footer.php'; ?>