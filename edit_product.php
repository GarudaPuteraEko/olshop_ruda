<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $conn->query("UPDATE products SET name = '$name', price = '$price', image = '$image' WHERE id = $id");
    header('Location: admin_index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Edit Product</h1>
    </header>
    <div class="container">
        <form method="post" action="">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required><br>
            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" value="<?php echo $product['image']; ?>" required><br>
            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>
