<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <div class="navbar">
        <a href="index.php">Home</a>
    </div>
    <div class="container">
        <form method="post" action="" class="form-container">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <p class="center-text">Tidak punya akun? <a href="register.php">Register disini</a></p>
    </div>
    <footer>
        <p>&copy; 2024 Ruda Shop. All Rights Reserved.</p>
    </footer>
</body>
</html>
