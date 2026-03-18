<?php
$base_path = isset($base_path) ? $base_path : ''; 
?>
<header class="nav-bar">
    <span id="logocompany"><a href="<?php echo $base_path; ?>index.php" style="color: inherit;">anginbnb</a></span>

    <div class="menu-page">
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'): ?>
            <a href="<?php echo $base_path; ?>admin/manage-users.php">Manage User</a>
            <a href="<?php echo $base_path; ?>admin/manage-properties.php">Manage Properties</a>
            <a href="<?php echo $base_path; ?>admin/manage-payment-types.php">Payment Types</a>
            <a href="<?php echo $base_path; ?>admin/manage-categories.php">Categories</a>
            <a href="<?php echo $base_path; ?>profile.php">Profile</a>
            <a href="<?php echo $base_path; ?>logout.php">Logout</a>

        <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Member'): ?>
            <a href="<?php echo $base_path; ?>index.php">Home</a>
            <a href="<?php echo $base_path; ?>properties.php">Properties</a>
            <a href="<?php echo $base_path; ?>my-bookings.php">My Bookings</a>
            <a href="<?php echo $base_path; ?>profile.php">Profile</a>
            <a href="<?php echo $base_path; ?>logout.php">Logout</a>

        <?php else: ?>
            <a href="<?php echo $base_path; ?>index.php">Home</a>
            <a href="<?php echo $base_path; ?>properties.php">Properties</a>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="welcome-msg" style="display: flex; gap: 15px; align-items: center;">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        </div>
    <?php else: ?>
        <div class="registration-page">
            <a href="<?php echo $base_path; ?>login.php" class="buttoninput">Login</a>
            <a href="<?php echo $base_path; ?>signup.php" class="buttoninput">Sign Up</a>
        </div>
    <?php endif; ?>
</header>