<?php
include 'config/database.php';
$page_css = 'assets/css/property-detail.css';
include 'components/header.php';
include 'components/navbar.php';


if (!isset($_GET['id'])) {
    header("Location: properties.php");
    exit();
}

$id = mysqli_real_escape_string($connect, $_GET['id']);

// Ambil data dari Database
$query = "SELECT p.*, c.CategoryName 
          FROM MsProperty p 
          JOIN MsCategory c ON p.CategoryID = c.CategoryID 
          WHERE p.PropertyID = '$id'";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<div class='container'><h2>Property not found!</h2></div>";
    include 'components/footer.php';
    exit();
}

$data = mysqli_fetch_assoc($result);
?>

<div id="Detailproperty">
    <h1><?php echo $data['PropertyName']; ?></h1>

    <div class="content-wrap">
        <div class="column-left">
            <div id="Detailtempat">
                <div class="detailtempat"> 
                    <p>Category</p>
                    <p><?php echo $data['CategoryName']; ?></p>
                </div>
                <div class="detailtempat">
                    <div>Rating</div>
                    <div><?php echo number_format($data['PropertyRating'], 1); ?>/10.0</div>
                </div>
                <div class="detailtempat">
                    <div>Location</div>
                    <div><?php echo $data['PropertyLocation']; ?></div>
                </div>
                <div class="detailtempat">
                    <div>Price</div>
                    <div id="harga">$<?php echo number_format($data['PropertyPrice']); ?>/night</div>
                </div>
            </div>

            <div id="aboutplace">
                <h2>About This Place</h2>
                <p><?php echo nl2br($data['PropertyDescription']); ?></p>
            </div>
        </div>

        <div id="Reserve-box">
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <h2>Reserve This Property</h2>
                <div id="pricedisplay">
                    <h3>$<?php echo number_format($data['PropertyPrice']); ?></h3>
                    <p>/night</p>
                </div>

                <form action="controllers/booking_controller.php" method="POST">
                    <input type="hidden" name="property_id" value="<?php echo $data['PropertyID']; ?>">
                    <input type="hidden" name="price_per_night" value="<?php echo $data['PropertyPrice']; ?>">
                    
                    <div class="datainputbox">
                        <div class="data-input-form">
                            <label for="check-in">Check In</label>
                            <input type="date" id="check-in" name="check_in" required>
                        </div>
                        <div class="data-input-form">
                            <label for="check-out">Check Out</label>
                            <input type="date" id="check-out" name="check_out" required>
                        </div>
                    </div>

                    <div class="payment-method">
                        <label for="payment-method">Payment Method</label>
                        <select name="payment_type_id" id="payment-method" required>
                            <option value="">Select Payment Method</option>

                            <?php
                            $pay_query = mysqli_query($connect, "SELECT * FROM MsPaymentType");
                            while ($pay = mysqli_fetch_assoc($pay_query)) {
                                echo "<option value='".$pay['PaymentTypeID']."'>".$pay['PaymentTypeName']."</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" id="reserve-btn">Reserve Now</button>
                    </div>
                </form>

            <?php else: ?>
                <h2>Ready to book?</h2>
                <p style="text-align: center; margin-bottom: 20px;">Sign in to reserve this amazing property</p>
                <div class="payment-method">
                    <a href="login.php" style="display: block; width: 100%;">
                        <button type="button" id="reserve-btn">Sign In</button>
                    </a>
                    <p style="margin-top: 15px; text-align: center;">Don't have an account? <a href="signup.php" style="color: #ff385c;">Sign up</a></p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>