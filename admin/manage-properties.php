<?php
session_start();
include '../config/database.php';

// Cek Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

// Buat tambah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $location = mysqli_real_escape_string($connect, $_POST['location']);
    $price = (int)$_POST['price'];
    $rating = (float)$_POST['rating'];
    $category_id = (int)$_POST['category'];
    $description = mysqli_real_escape_string($connect, $_POST['description']);

    // Validasi
    if (!empty($name) && !empty($location) && $price > 0 && $category_id > 0) {
        $insert = "INSERT INTO MsProperty (PropertyName, PropertyLocation, PropertyPrice, PropertyRating, CategoryID, PropertyDescription) 
                   VALUES ('$name', '$location', '$price', '$rating', '$category_id', '$description')";
        
        if (mysqli_query($connect, $insert)) {
            echo "<script>alert('Property added successfully!'); window.location.href='manage-properties.php';</script>";
        } else {
            echo "<script>alert('Error adding property.');</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields correctly.');</script>";
    }
}

// Delete
if (isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    mysqli_query($connect, "DELETE FROM MsProperty WHERE PropertyID = $id");
    echo "<script>alert('Property deleted!'); window.location.href='manage-properties.php';</script>";
}


$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
$where = "WHERE PropertyName LIKE '%$search%' OR PropertyLocation LIKE '%$search%'";

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Hitung total data
$total_res = mysqli_query($connect, "SELECT count(*) as total FROM MsProperty $where");
$total_row = mysqli_fetch_assoc($total_res);
$total_pages = ceil($total_row['total'] / $limit);

// Ambil Data
$query = "SELECT p.*, c.CategoryName 
          FROM MsProperty p 
          JOIN MsCategory c ON p.CategoryID = c.CategoryID 
          $where 
          ORDER BY p.PropertyID ASC 
          LIMIT $start, $limit";
$result = mysqli_query($connect, $query);

// Dropdown
$cat_result = mysqli_query($connect, "SELECT * FROM MsCategory");


$base_path = '../';
$page_css = $base_path . 'assets/css/manageproperti.css';
include '../components/header.php';
include '../components/navbar.php';
?>

<main>
    <div class="container">
        <h1>Manage Properties</h1>
        <p>Create and manage all properties listing</p>
        
        <div class="form-card">
            <h2 class="judulForm">Create New Property</h2>
            <form action="" method="POST" class="create-property-form">
                <input type="hidden" name="action" value="create">
                
                <div class="formbox">
                    <div class="form-isi">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-isi">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" required>
                    </div>
                    
                    <div class="form-isi">
                        <label for="price">Price ($)</label>
                        <input type="number" id="price" name="price" min="1" required>
                    </div>
    
                    <div class="form-isi">
                        <label for="rating">Rating (0-10)</label>
                        <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" value="0">
                    </div>
                    
                    <div class="form-isi">
                        <label for="category-select">Category</label>
                        <select id="category-select" name="category" required>
                            <option value="">Select Category</option>
                            <?php while($cat = mysqli_fetch_assoc($cat_result)): ?>
                                <option value="<?php echo $cat['CategoryID']; ?>">
                                    <?php echo $cat['CategoryName']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            
                <div class="form-desc">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>
                <button type="submit" class="create-btn">Create Property</button>
            </form>
        </div>
        
        <div class="isi-properti">
            <h2 class="judulproperti">Existing Properties</h2>
            <div class="search-controls">
                <div class="search-info">
                    <p class="total-properties"><?php echo $total_row['total']; ?> total properties found</p>
                    <p class="page-info">Page <?php echo $page; ?> of <?php echo $total_pages; ?></p>
                </div>
                
                <form action="" method="GET" class="searchbar" style="display:flex;">
                    <input type="text" name="search" placeholder="Search properties..." class="input-search" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>

            <div class="properties-grid">
                <div class="grid-category">
                    <div class="category">ID</div>
                    <div class="category">Property Name</div>
                    <div class="category">Price</div>
                    <div class="category">Location</div>
                    <div class="category">Rating</div>
                    <div class="category">Category</div>
                    <div class="category">Actions</div>
                </div>

                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <div class="data-row">
                            <div class="isi-data-property"><?php echo $row['PropertyID']; ?></div>
                            <div class="isi-data-property"><?php echo $row['PropertyName']; ?></div>
                            <div class="isi-data-property">$<?php echo number_format($row['PropertyPrice']); ?></div>
                            <div class="isi-data-property"><?php echo $row['PropertyLocation']; ?></div>
                            <div class="isi-data-property"><?php echo $row['PropertyRating']; ?></div>
                            <div class="isi-data-property"><?php echo $row['CategoryName']; ?></div>
                            <div class="action-buttons">
                                <a href="admin/edit-property.php?id=<?php echo $row['PropertyID']; ?>">
                                    <button class="Edit" type="button">Edit</button>
                                </a>
                                
                                <form action="" method="POST" style="display:inline;" onsubmit="return confirm('Delete this property?');">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['PropertyID']; ?>">
                                    <button type="submit" class="Delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; padding: 20px;">No properties found.</p>
                <?php endif; ?>

            </div>

            <div class="pagination">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="admin/manage-properties.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>" 
                       class="<?php echo ($i == $page) ? 'page-active' : 'next-page'; ?>">
                       <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</main>

<?php include '../components/footer.php'; ?>