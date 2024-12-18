<?php
include 'db.php';
session_start();

// Handle search
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$query = "SELECT * FROM products WHERE is_active = 1";

if (!empty($search)) {
    $query .= " AND (name LIKE '%$search%')";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ruda Shop</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to Ruda Shop</h1>
    </header>
    <div class="navbar">
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
            <a href="cart.php">Cart</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <h2>Products</h2>
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
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a class="btn" href="add_to_cart.php?id=<?php echo $row['id']; ?>">Add to cart</a>
                        <?php endif; ?>
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
