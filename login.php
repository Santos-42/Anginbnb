<?php 
session_start();
include 'config/database.php';
// Cek cookie
if (isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])) {
    
    $uid = $_COOKIE['user_id'];
    $q = mysqli_query($connect, "SELECT * FROM MsUser WHERE UserID = '$uid'");
    if(mysqli_num_rows($q) > 0){
        $u = mysqli_fetch_assoc($q);
        $_SESSION['user_id'] = $u['UserID'];
        $_SESSION['user_name'] = $u['UserName'];
        $_SESSION['user_role'] = $u['UserRole'];
        header("Location: index.php");
        exit();
    }
}

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$page_css = 'assets/css/login.css'; 
include 'components/header.php'; 
include 'components/navbar.php'; 
?>

<main>
    <form action="controllers/auth_controller.php" method="POST" id="form-location" style="margin-bottom: 10px;">
        <input type="hidden" name="action" value="login">

        <div id="form-box">
            <span id="sambutan-signin">Welcome Back</span>
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <div style="background: #ddffdd; color: green; padding: 10px; margin-bottom: 10px; border-radius: 5px; text-align: center;">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div style="background: #ffdddd; color: red; padding: 10px; margin-bottom: 10px; border-radius: 5px; text-align: center;">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <div class="input-form">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Input Your email here" value="<?php echo isset($_SESSION['old_email']) ? htmlspecialchars($_SESSION['old_email']) : ''; ?>" required>
            </div>
            <div class="input-form">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Input Your password here" required>
            </div>
            <div class="terms">
                <input type="checkbox" id="remember-me" name="remember_me">
                <label for="remember-me">Remember me for 7 days</label>
            </div>
            
            <button type="submit" id="submit-btn">Sign In</button> 
            
            <div>
                <span id="reminder">Don't have an account? <a href="signup.php" id="signuphref">Sign Up</a></span>
            </div>
        </div>
    </form>
    <?php
    unset($_SESSION['old_email']);
    ?>
</main>

<?php include 'components/footer.php'; ?>