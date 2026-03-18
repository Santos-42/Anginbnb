<?php
session_start();
include '../config/database.php';

// Cek Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

// Tambah payment
if (isset($_POST['add_payment'])) {
    $payment_name = mysqli_real_escape_string($connect, $_POST['payment_name']);
    if (!empty($payment_name)) {
        mysqli_query($connect, "INSERT INTO MsPaymentType (PaymentTypeName) VALUES ('$payment_name')");
        echo "<script>alert('Payment type added!'); window.location.href='manage-payment-types.php';</script>";
    }
}

// Hapus Payment
if (isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    mysqli_query($connect, "DELETE FROM MsPaymentType WHERE PaymentTypeID = $id");
    echo "<script>alert('Payment type deleted!'); window.location.href='manage-payment-types.php';</script>";
}


$query = "SELECT * FROM MsPaymentType";
$result = mysqli_query($connect, $query);
$total_types = mysqli_num_rows($result);


$base_path = '../';
$page_css = $base_path . 'assets/css/payment.css';
include '../components/header.php';
include '../components/navbar.php';
?>

<main>
    <div class="container">
        <h1>Payment Types Management</h1>
        <p>Manage all available payment methods</p>
        
        <div class="search-bar">
            <h2 class="titlepayment">Create New Payment Type</h2>
            <p id="Typepayment"><?php echo $total_types; ?> Payment types in System</p>
            
            <form action="" method="POST" style="display:flex; gap:10px; width:100%;">
                <input type="text" name="payment_name" id="enterpayment" placeholder="Enter Payment Type Name..." required>
                <button type="submit" name="add_payment" id="search-btn">Create</button>
            </form>
        </div>
        
        <div class="isi-properti">
            <div class="properties-grid">
                <div class="grid-category">
                    <div class="category">ID</div>
                    <div class="category">Payment Type</div>
                    <div class="category">Actions</div>
                </div>

                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="data-row">
                        <div class="isi-data-property"><?php echo $row['PaymentTypeID']; ?></div>
                        <div class="isi-data-property"><?php echo $row['PaymentTypeName']; ?></div>
                        <div class="action-buttons">
                            <form action="" method="POST" onsubmit="return confirm('Delete this payment type?');">
                                <input type="hidden" name="delete_id" value="<?php echo $row['PaymentTypeID']; ?>">
                                <button type="submit" class="Delete">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</main>

<?php include '../components/footer.php'; ?>