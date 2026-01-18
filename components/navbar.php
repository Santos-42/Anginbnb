<header class="nav-bar">
    <span id="logocompany"><a href="index.php" style="color: inherit;">anginbnb</a></span>

    <div class="menu-page">
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'): ?>
            <a href="admin/manage-users.php">Manage User</a>
            <a href="admin/manage-properties.php">Manage Properties</a>
            <a href="admin/manage-payment-types.php">Payment Types</a>
            <a href="admin/manage-categories.php">Categories</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>

        <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Member'): ?>
            <a href="index.php">Home</a>
            <a href="properties.php">Properties</a>
            <a href="my-bookings.php">My Bookings</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>

        <?php else: ?>
            <a href="index.php">Home</a>
            <a href="properties.php">Properties</a>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="welcome-msg" style="display: flex; gap: 15px; align-items: center;">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            
        </div>
    <?php else: ?>
        <div class="registration-page">
            <a href="login.php" class="buttoninput">Login</a>
            <a href="signup.php" class="buttoninput">Sign Up</a>
        </div>
    <?php endif; ?>
</header>