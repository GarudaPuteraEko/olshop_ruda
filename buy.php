<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Process the purchase and clear the cart
$conn->query("DELETE FROM cart WHERE user_id='$user_id'");

// Redirect to the success page
header("Location: success.php");
exit();
?>
