<?php
include 'db.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Proses file gambar
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];

    // Tentukan folder penyimpanan gambar
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    
    // Periksa apakah file gambar valid
    if (move_uploaded_file($image_temp, $target_file)) {
        // Query untuk menyimpan produk baru dengan gambar
        $query = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$target_file')";
        
        if ($conn->query($query)) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Add Product</h1>
    </header>
    <div class="navbar">
        <a href="admin_index.php">Back to Admin Dashboard</a>
    </div>
    <div class="container">
        <form method="post" action="" enctype="multipart/form-data" class="form-container">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required><br>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required><br>

            <input type="submit" value="Add Product">
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Ruda Shop. All Rights Reserved.</p>
    </footer>
</body>
</html>
