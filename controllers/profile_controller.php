<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Update info
if (isset($_POST['update_info'])) {
    $fullname = mysqli_real_escape_string($connect, $_POST['fullname']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);

    
    if (strlen($fullname) < 3 || strlen($fullname) > 50) {
        $_SESSION['error'] = "Name must be 3-50 chars.";
    } else {
        $update = "UPDATE MsUser SET UserName='$fullname', UserEmail='$email' WHERE UserID='$user_id'";
        if (mysqli_query($connect, $update)) {
            $_SESSION['user_name'] = $fullname; 
            $_SESSION['success'] = "Profile updated successfully!";
        } else {
            $_SESSION['error'] = "Update failed: " . mysqli_error($connect);
        }
    }
    header("Location: ../profile.php");
    exit();
}

// Update pw
if (isset($_POST['update_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    
    $q = mysqli_query($connect, "SELECT UserPassword FROM MsUser WHERE UserID='$user_id'");
    $data = mysqli_fetch_assoc($q);

    if ($data['UserPassword'] !== $current) {
        $_SESSION['error'] = "Current password is wrong!";
    } elseif ($new !== $confirm) {
        $_SESSION['error'] = "New passwords do not match!";
    } elseif (strlen($new) < 8) { 
        $_SESSION['error'] = "Password too short!";
    } else {
        $up = "UPDATE MsUser SET UserPassword='$new' WHERE UserID='$user_id'";
        if (mysqli_query($connect, $up)) {
            $_SESSION['success'] = "Password changed successfully!";
        }
    }
    header("Location: ../profile.php");
    exit();
}

// Delete akun
if (isset($_POST['delete_account'])) {
    mysqli_query($connect, "DELETE FROM MsUser WHERE UserID='$user_id'");
    
    // Logout
    session_unset();
    session_destroy();
    setcookie('user_id', '', time() - 3600, "/");
    
    header("Location: ../login.php");
    exit();
}
?>