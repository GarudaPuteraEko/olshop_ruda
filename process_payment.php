<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = 0;

// Ambil semua produk di keranjang
$sql_cart = "SELECT cart.product_id, SUM(cart.quantity) as total_quantity, products.price 
             FROM cart 
             INNER JOIN products ON cart.product_id = products.id 
             WHERE cart.user_id = '$user_id' 
             GROUP BY cart.product_id";
$result_cart = $conn->query($sql_cart);

if ($result_cart->num_rows > 0) {
    while ($row = $result_cart->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['total_quantity'];
        $price = $row['price'];
        $subtotal = $quantity * $price;
        $total_price += $subtotal;

        $sql_insert_transaction = "INSERT INTO transaction (user_id, product_id, quantity, total_price, transaction_date) 
                                   VALUES ('$user_id', '$product_id', '$quantity', '$subtotal', NOW())";
        if (!$conn->query($sql_insert_transaction)) {
            echo "Error: " . $sql_insert_transaction . "<br>" . $conn->error;
        }
    }

    // Clear the cart
    $sql_clear_cart = "DELETE FROM cart WHERE user_id='$user_id'";
    $conn->query($sql_clear_cart);

    // Redirect to success page
    header("Location: success.php");
    exit();
} else {
    echo "Your cart is empty.";
}
?>
