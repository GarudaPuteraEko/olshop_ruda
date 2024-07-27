<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT cart.id, products.name, products.price, cart.quantity, products.image 
                        FROM cart 
                        INNER JOIN products ON cart.product_id = products.id 
                        WHERE cart.user_id = '$user_id'");

$total_price = 0;
$cart_empty = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_id = $_POST['cart_id'];
    $sql = "DELETE FROM cart WHERE id='$cart_id'";
    $conn->query($sql);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Your Cart</h1>
    </header>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
        <a href="cart.php">Cart</a>
    </div>
    <div class="container">
        <ul>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="product-card">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <div class="product-info">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Price: <?php echo $row['price']; ?> x <?php echo $row['quantity']; ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" value="Remove">
                        </form>
                    </div>
                </li>
                <?php
                $total_price += $row['price'] * $row['quantity'];
                $cart_empty = false;
                ?>
            <?php } ?>
        </ul>
        <h2>Total Price: <?php echo $total_price; ?></h2>
        <?php if (!$cart_empty) { ?>
            <a class="btn" href="process_payment.php">Buy</a>
        <?php } else { ?>
            <p class="notice">Tidak ada barang di keranjang.</p>
        <?php } ?>
        <a href="index.php">Back to Products</a>
    </div>
    <footer>
        <p>&copy; 2024 Ruda Shop. All Rights Reserved.</p>
    </footer>
</body>
</html>
