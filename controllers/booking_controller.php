<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_SESSION['user_id'];
    $property_id = $_POST['property_id'];
    $payment_type_id = $_POST['payment_type_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $price_per_night = $_POST['price_per_night'];

    if ($check_in >= $check_out) {
        echo "<script>alert('Check-out date must be after Check-in date!'); window.history.back();</script>";
        exit();
    }

    
    $date1 = new DateTime($check_in);
    $date2 = new DateTime($check_out);
    $interval = $date1->diff($date2);
    $days = $interval->days; 
    
    $total_price = $days * $price_per_night;

    
    $query = "INSERT INTO MsTransaction (CheckIn, CheckOut, PaymentTypeID, UserID, PropertyID, TotalPrice) 
              VALUES ('$check_in', '$check_out', '$payment_type_id', '$user_id', '$property_id', '$total_price')";

    if (mysqli_query($connect, $query)) {
        // Ke halaman My Bookings
        header("Location: ../my-bookings.php");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>