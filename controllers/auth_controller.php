<?php
session_start();
include '../config/database.php';

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'register') {
    $fullname = mysqli_real_escape_string($connect, $_POST['fullname']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    
    $errors = [];

    // Validasi Nama (3-50 karakter)
    if (strlen($fullname) < 3 || strlen($fullname) > 50) {
        $errors[] = "Name must be between 3 to 50 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
        $errors[] = "Name must contain only letters and spaces.";
    }

    // Validasi Password (8 chars, upper, lower, number, special)
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W_]/', $password)) {
        $errors[] = "Password must be at least 8 chars, contain uppercase, lowercase, number, and special char.";
    }

    // Validasi Email
    $check_email = mysqli_query($connect, "SELECT UserID FROM MsUser WHERE UserEmail = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $errors[] = "Email is already registered.";
    }

    // Error
    if (count($errors) > 0) {
        $_SESSION['error_message'] = $errors[0];
        $_SESSION['old_fullname'] = $fullname;
        $_SESSION['old_email'] = $email;
        header("Location: ../signup.php");
        exit();
    }

    
    $query = "INSERT INTO MsUser (UserName, UserEmail, UserPassword, UserRole) VALUES ('$fullname', '$email', '$password', 'Member')";
    
    if (mysqli_query($connect, $query)) {
        $_SESSION['success_message'] = "Registration successful! Please login.";
        header("Location: ../login.php");
    } else {
        echo "Error: " . mysqli_error($connect);
    }

} elseif ($action == 'login') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    
    $query = "SELECT * FROM MsUser WHERE UserEmail = '$email' AND UserPassword = '$password'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Set Session
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_name'] = $user['UserName'];
        $_SESSION['user_role'] = $user['UserRole'];

        // Remember Me
        if (isset($_POST['remember_me'])) {
            setcookie('user_id', $user['UserID'], time() + (86400 * 7), "/"); // 86400 = 1 hari
        }

        // Menyesuaikan Role
        if ($user['UserRole'] == 'Admin') {
            header("Location: ../index.php");
        } else {
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
        $_SESSION['old_email'] = $email;
        header("Location: ../login.php");
    }
}
?>