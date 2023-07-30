<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "ShortLink");

if (isset($_POST['Login'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    $query = "SELECT * FROM users WHERE Username='$username' AND Password='$password';";
    $result = mysqli_query($connect, $query);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: home.php');
    } else {
        echo '<script>alert("Login gagal. Silakan cek kembali username dan password Anda.");</script>';
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            padding: 20px;
            background-color: #007BFF;
            color: #fff;
            margin: 0;
        }
        form {
            margin-top: 30px;
        }
        input[type="text"],
        input[type="password"] {
            width: 250px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Login to ShortLink</h1>
    <?php
    if (!isset($_SESSION['username'])) {
        echo '<p>Anda belum login. Silakan <a href="register.php">daftar</a> terlebih dahulu.</p>';
    }
    ?>
    <form method="POST">
        <input type="text" name="Username" placeholder="Username" required>
        <br>
        <input type="password" name="Password" placeholder="Password" required>
        <br>
        <input type="submit" name="Login" value="Login">
    </form>
    <br>
    <p>Belum punya akun? Silakan <a href="register.php">daftar disini</a>.</p>
</body>
</html>
