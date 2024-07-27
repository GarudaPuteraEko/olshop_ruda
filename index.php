<?php
include 'db.php';
session_start();

$result = $conn->query("SELECT * FROM products");
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
