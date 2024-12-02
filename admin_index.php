<?php
include 'db.php';
session_start();

// Periksa apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Handle search
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$query = "SELECT * FROM products WHERE is_active = 1";

if (!empty($search)) {
    $query .= " AND (name LIKE '%$search%')";
}

$result = $conn->query($query);

// Tambahkan fungsi untuk menghapus produk
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("UPDATE products SET is_active = 0 WHERE id = $delete_id");
    header('Location: admin_index.php'); // Refresh halaman
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Ruda Shop</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <header>
        <h1>Admin Dashboard - Ruda Shop</h1>
    </header>
    <div class="navbar">
        <a href="admin_index.php">Home</a>
        <a href="add_product.php">Add Product</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Manage Products</h2>
        <form method="GET" action="" class="search-form">
            <input type="text" name="search" placeholder="Search products..."
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit">Search</button>
        </form>
        <div class="product-list">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="product-card">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <div class="product-info">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Price: <?php echo $row['price']; ?></p>
                        <a class="btn" href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Ruda Shop. All Rights Reserved.</p>
    </footer>
</body>

</html>