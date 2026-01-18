<?php include 'config/database.php'; ?>
<?php include 'components/header.php'; ?>
<?php include 'components/navbar.php'; ?>

<main>
    <div id="banner">
        <h1>Find your next adventure</h1>
        <p>Discover unique places to stay around the world with Anginbnb</p>
    </div>

    <div id="category">
        <h1>Explore by category</h1>
        <div class="boxcategory">
            <a href="properties.php?cat=1" class="category-item">
                <h2>Hotel</h2>
                <p>Discover amazing hotel rental</p>
            </a>
            <a href="properties.php?cat=2" class="category-item">
                <h2>Apartment</h2>
                <p>Discover amazing apartment rentals</p>
            </a>
            <a href="properties.php?cat=3" class="category-item">
                <h2>Villa</h2>
                <p>Discover amazing villa rentals</p>
            </a>
            <a href="properties.php?cat=4" class="category-item">
                <h2>Resort</h2>
                <p>Discover amazing resort rentals</p>
            </a>
        </div>
    </div>

    <div id="featured-properti">
        <h1>Featured Properties</h1>
        <div class="boxproperti">
            
            <?php
            $query = "SELECT p.*, c.CategoryName 
                      FROM MsProperty p 
                      JOIN MsCategory c ON p.CategoryID = c.CategoryID 
                      ORDER BY p.PropertyRating DESC 
                      LIMIT 6";
            
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="isiproperti">
                        <h3><?php echo $row['PropertyName']; ?></h3>
                        <p class="category-tag"><?php echo $row['CategoryName']; ?></p>
                        <p class="rating"><?php echo $row['PropertyRating']; ?>/10.0</p>
                        <p class="Location"><?php echo $row['PropertyLocation']; ?></p>
                        <p class="Price">$<?php echo number_format($row['PropertyPrice']); ?>/night</p>
                        <a href="property-detail.php?id=<?php echo $row['PropertyID']; ?>" class="view-detail">View Detail</a>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No properties found.</p>";
            }
            ?>

        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?>