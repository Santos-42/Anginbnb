<?php
session_start();
include '../config/database.php';

// Memastikan Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin') {
    header("Location: ../login.php");
    exit();
}

// Delete User
if (isset($_POST['delete_user_id'])) {
    $id_to_delete = $_POST['delete_user_id'];
    
    
    if ($id_to_delete != $_SESSION['user_id']) {
        mysqli_query($connect, "DELETE FROM MsUser WHERE UserID = '$id_to_delete'");
    }
}


$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
$where = "WHERE UserName LIKE '%$search%'";


$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;


$total_result = mysqli_query($connect, "SELECT count(*) as total FROM MsUser $where");
$total_row = mysqli_fetch_assoc($total_result);
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $limit);

// Data User
$query = "SELECT * FROM MsUser $where LIMIT $start, $limit";
$result = mysqli_query($connect, $query);


$base_path = '../';
$page_css = $base_path . 'assets/css/manageuser.css';
include '../components/header.php';
include '../components/navbar.php';
?>

<main>
    <div class="container">
        <h1>User Management</h1>
        <p>Manage and monitor all registered users</p>
        
        <div class="searchbox">
            <div id="classinfo">
                <div class="Juduluser">
                    <p id="Search">Search User</p>
                    <p id="totaluser"><?php echo $total_users; ?> Total users found</p>   
                </div>
                <p id="pageshow">Page <?php echo $page; ?> of <?php echo $total_pages; ?></p>
            </div>
            
            <form action="" method="GET" id="searchbar" style="display:flex; width:100%;">
                <input type="text" name="search" placeholder="Search by username..." id="inputclass" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" id="search-btn">Search</button>
            </form>
        </div>

        <div class="grid-user">
            <div class="user-header">
                <div class="isi-header">ID</div>
                <div class="isi-header">User Details</div>
                <div class="isi-header" id="roleheader">Role</div>
                <div class="isi-header" id="action">Actions</div>
            </div>

            <div class="usergrid">
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    
                    <div class="datauser">
                        <div class="UserID"><?php echo $row['UserID']; ?></div>
                        <div class="userdetails">
                            <p><?php echo htmlspecialchars($row['UserName']); ?></p>
                            <p><?php echo htmlspecialchars($row['UserEmail']); ?></p>
                        </div>
                    </div>
                    
                    <div class="role" <?php if($row['UserRole'] == 'Admin') echo 'id="tulisanadmin"'; ?>>
                        <?php echo $row['UserRole']; ?>
                    </div>
                    
                    <div class="actionbutton">
                        <?php if ($row['UserID'] == $_SESSION['user_id']): ?>
                            <button id="editadmin" disabled style="opacity:0.5;">Edit</button>
                            <span id="admin-label">(You)</span>
                        <?php else: ?>
                            <a href="edit-user.php?id=<?php echo $row['UserID']; ?>">
                                <button class="edit" type="button">Edit</button>
                            </a>
                            
                            <form action="" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure delete this user?');">
                                <input type="hidden" name="delete_user_id" value="<?php echo $row['UserID']; ?>">
                                <button type="submit" class="Delete">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>

        <div class="pagination">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <a href="manage-users.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>" 
                   class="<?php echo ($i == $page) ? 'page-active' : 'next-page'; ?>">
                   <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</main>

<?php include '../components/footer.php'; ?>