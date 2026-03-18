<?php
session_start();
include '../config/database.php';

// Cek Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

// Create kategori
if (isset($_POST['add_category'])) {
    $cat_name = mysqli_real_escape_string($connect, $_POST['category_name']);
    if (!empty($cat_name)) {
        mysqli_query($connect, "INSERT INTO MsCategory (CategoryName) VALUES ('$cat_name')");
        echo "<script>alert('Category added!'); window.location.href='manage-categories.php';</script>";
    }
}

// Delete kategori
if (isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    mysqli_query($connect, "DELETE FROM MsCategory WHERE CategoryID = $id");
    echo "<script>alert('Category deleted!'); window.location.href='manage-categories.php';</script>";
}


$query = "SELECT * FROM MsCategory";
$result = mysqli_query($connect, $query);
$total_cats = mysqli_num_rows($result);

$base_path = '../';
$page_css = $base_path . 'assets/css/managecategories.css';
include '../components/header.php';
include '../components/navbar.php';
?>

<main>
    <div class="container">
        <h1>Categories Management</h1>
        <p>Manage All Property Categories</p>
        
        <div class="search-bar">
            <h2 class="titlecat">Create New Category</h2>
            <p id="Typecat"><?php echo $total_cats; ?> Categories in System</p>
            
            <form action="" method="POST" style="display:flex; gap:10px; width:100%;">
                <input type="text" name="category_name" id="entercat" placeholder="Enter Category Name..." required>
                <button type="submit" name="add_category" id="search-btn">Create</button>
            </form>
        </div>
        
        <div class="isi-properti">
            <div class="properties-grid">
                <div class="grid-category">
                    <div class="category">ID</div>
                    <div class="category">Category Name</div>
                    <div class="category">Actions</div>
                </div>

                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="data-row">
                        <div class="isi-data-property"><?php echo $row['CategoryID']; ?></div>
                        <div class="isi-data-property"><?php echo $row['CategoryName']; ?></div>
                        <div class="action-buttons">
                            <form action="" method="POST" onsubmit="return confirm('Delete this category?');">
                                <input type="hidden" name="delete_id" value="<?php echo $row['CategoryID']; ?>">
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