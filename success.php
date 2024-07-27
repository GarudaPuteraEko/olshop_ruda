<?php
include 'db.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction Success</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Transaction Successful</h1>
    </header>
    <div class="navbar">
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
        <a href="cart.php">Cart</a>
    </div>
    <div class="container">
        <h1>Transaction Successful</h1>
        <p>Terimakasih telah berbelanja. Transaksimu sedang diproses!</p>
        <a href="index.php" class="button">Back to Products</a>
    </div>
    <footer>
        <p>&copy; 2024 Ruda Shop. All Rights Reserved.</p>
    </footer>
</body>
</html>
