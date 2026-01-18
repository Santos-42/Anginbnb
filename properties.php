<?php 
include 'config/database.php'; 
include 'components/header.php'; 
?>

<link rel="stylesheet" href="assets/css/properties.css">

<?php include 'components/navbar.php'; ?>

<main>
    <h1>All Properties</h1>

    <div class="filters">
        <form action="" method="GET" class="searchbar" style="display: contents;">
            
            <div class="searchbar" style="width: 100%;">
                <input type="text" name="search" 
                       placeholder="Search properties by name or location..." 
                       value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" id="search-btn">Search</button>
            </div>

            <div class="category-filters">
                <select name="cat" id="category-select-properti">
                    <option value="">All Categories</option>
                    <?php
                    $cat_query = mysqli_query($connect, "SELECT * FROM MsCategory");
                    while($cat = mysqli_fetch_assoc($cat_query)) {
                        $selected = (isset($_GET['cat']) && $_GET['cat'] == $cat['CategoryID']) ? 'selected' : '';
                        echo "<option value='".$cat['CategoryID']."' $selected>".$cat['CategoryName']."</option>";
                    }
                    ?>
                </select>
                <button type="submit" id="filter-btn">Filter</button>
            </div>
        </form>
    </div>

    <div class="properties-grid">
        <div class="boxproperti">

            <?php
            $where_clauses = [];
            
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($connect, $_GET['search']);
                $where_clauses[] = "(PropertyName LIKE '%$search%' OR PropertyLocation LIKE '%$search%')";
            }

            if (isset($_GET['cat']) && !empty($_GET['cat'])) {
                $cat_id = mysqli_real_escape_string($connect, $_GET['cat']);
                $where_clauses[] = "p.CategoryID = '$cat_id'";
            }

            $sql = "SELECT p.*, c.CategoryName 
                    FROM MsProperty p 
                    JOIN MsCategory c ON p.CategoryID = c.CategoryID";
            
            if (count($where_clauses) > 0) {
                $sql .= " WHERE " . implode(' AND ', $where_clauses);
            }

            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="isiproperti">
                        <h3><?php echo $row['PropertyName']; ?></h3>
                        <p class="category-tag"><?php echo $row['CategoryName']; ?></p>
                        
                        <p class="rating"><?php echo number_format($row['PropertyRating'], 1); ?>/10.0</p>
                        
                        <p class="Location"><?php echo $row['PropertyLocation']; ?></p>
                        
                        <p class="Price">$<?php echo number_format($row['PropertyPrice']); ?>/night</p>
                        
                        <a href="property-detail.php?id=<?php echo $row['PropertyID']; ?>" class="view-detail">view detail</a>
                    </div>
            <?php
                }
            } else {
                echo "<p style='grid-column: 1/-1; text-align: center;'>No properties found matching your criteria.</p>";
            }
            ?>

        </div>
    </div>

    <div class="pagination">
        <a href="#" class="page-active">1</a>
        <a href="#" class="next-page">2</a>
        <a href="#" class="next-page">3</a>
        <a href="#" class="next-page">4</a>
    </div>
</main>

<?php include 'components/footer.php'; ?>