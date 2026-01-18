<?php
include 'config/database.php';

// Cek Login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page_css = 'assets/css/my-bookings.css';
include 'components/header.php';
include 'components/navbar.php';

$user_id = $_SESSION['user_id'];

// Query Transaksi
$query = "SELECT t.*, p.PropertyName, pt.PaymentTypeName 
          FROM MsTransaction t
          JOIN MsProperty p ON t.PropertyID = p.PropertyID
          JOIN MsPaymentType pt ON t.PaymentTypeID = pt.PaymentTypeID
          WHERE t.UserID = '$user_id'
          ORDER BY t.TransactionID ASC";

$result = mysqli_query($connect, $query);
?>

<main>
    <div class="container">
        <h1>My Bookings</h1>
        <p>Manage your current and past reservations</p>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="bookinggrid-wrapper">
                <div class="bookinggrid" style="font-weight: bold; background-color: #f9f9f9;">
                    <div class="judulbooking">ID</div>
                    <div class="judulbooking">Property</div>
                    <div class="judulbooking">Payment Method</div>
                    <div class="judulbooking">Check-in</div>
                    <div class="judulbooking">Check-out</div>
                    <div class="judulbooking">Total Price</div>
                </div>

                <div class="isibooking">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="isibookinggrid">
                            <div class="booking-id">#<?php echo $row['TransactionID']; ?></div>
                            <div class="property-name" style="font-weight: 600;"><?php echo $row['PropertyName']; ?></div>
                            <div class="Isi"><?php echo $row['PaymentTypeName']; ?></div>
                            <div class="Isi"><?php echo date('M d, Y', strtotime($row['CheckIn'])); ?></div>
                            <div class="Isi"><?php echo date('M d, Y', strtotime($row['CheckOut'])); ?></div>
                            <div class="Isi total-price" style="font-weight: bold;">
                                $<?php echo number_format($row['TotalPrice']); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="isibooking" style="text-align: center; padding: 50px;">
                <h2 style="color: #555;">No Bookings Yet</h2>
                <p>You haven't made any bookings yet. Start exploring amazing properties!</p>
                <a href="properties.php" id="browse-btn" style="display: inline-block; width: auto; padding: 12px 30px; margin-top: 20px;">
                    Browse Properties
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include 'components/footer.php'; ?>