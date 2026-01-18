<?php
session_start();
include '../config/database.php';

// Cek admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}


if (!isset($_GET['id'])) {
    header("Location: manage-properties.php");
    exit();
}
$id = (int)$_GET['id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $location = mysqli_real_escape_string($connect, $_POST['location']);
    $price = (int)$_POST['price'];
    $rating = (float)$_POST['rating'];
    $category_id = (int)$_POST['category'];
    $description = mysqli_real_escape_string($connect, $_POST['description']);

    $update = "UPDATE MsProperty SET 
               PropertyName='$name', 
               PropertyLocation='$location', 
               PropertyPrice='$price', 
               PropertyRating='$rating', 
               CategoryID='$category_id', 
               PropertyDescription='$description' 
               WHERE PropertyID=$id";

    if (mysqli_query($connect, $update)) {
        echo "<script>alert('Property updated successfully!'); window.location.href='manage-properties.php';</script>";
    } else {
        echo "<script>alert('Error updating property.');</script>";
    }
}


$query = mysqli_query($connect, "SELECT * FROM MsProperty WHERE PropertyID = $id");
$data = mysqli_fetch_assoc($query);


if (!$data) {
    echo "Property not found!";
    exit();
}

// Ambil Kategori untuk Dropdown
$cat_result = mysqli_query($connect, "SELECT * FROM MsCategory");


$page_css = 'assets/css/editproperti.css';
include '../components/header.php';
include '../components/navbar.php';
?>

<main>
    <div class="container">
        <h1>Edit Property</h1>
        <p>Update Property Detail</p>
        
        <div class="card" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            
            <form action="" method="POST" id="form-editproperty">
                <div class="formbox">
                    
                    <div class="form-isi">
                        <label for="name">Property Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['PropertyName']); ?>" required>
                    </div>
                    
                    <div class="form-isi">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($data['PropertyLocation']); ?>" required>
                    </div>
                    
                    <div class="form-isi">
                        <label for="price">Price ($)</label>
                        <input type="number" id="price" name="price" min="1" value="<?php echo $data['PropertyPrice']; ?>" required>
                    </div>
    
                    <div class="form-isi">
                        <label for="rating">Rating (0-10)</label>
                        <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" value="<?php echo $data['PropertyRating']; ?>">
                    </div>
                    
                    <div class="form-isi">
                        <label for="category-select">Category</label>
                        <select id="category-select" name="category" required>
                            <option value="">Select Category</option>
                            <?php while($cat = mysqli_fetch_assoc($cat_result)): ?>
                                <option value="<?php echo $cat['CategoryID']; ?>" 
                                    <?php if($cat['CategoryID'] == $data['CategoryID']) echo 'selected'; ?>>
                                    <?php echo $cat['CategoryName']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-desc">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="5" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;"><?php echo htmlspecialchars($data['PropertyDescription']); ?></textarea>
                    </div>

                    <div class="button" style="margin-top: 30px; display: flex; gap: 15px;">
                        <a href="admin/manage-properties.php" style="text-decoration: none; width: 100%;">
                            <button type="button" class="update-button" style="width: 100%;">Back to List</button>
                        </a>
                        <button type="submit" class="update-button" style="width: 100%;">Update Property</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../components/footer.php'; ?>