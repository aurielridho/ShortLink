<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "ShortLink");

if (isset($_POST['Register'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Periksa apakah username sudah digunakan
    $check_username_query = "SELECT * FROM users WHERE Username = '$username'";
    $check_username_result = mysqli_query($connect, $check_username_query);

    if (mysqli_num_rows($check_username_result) > 0) {
        echo '<script>alert("Username sudah digunakan. Silakan pilih username lain.");</script>';
    } else {
        // Periksa panjang password (minimal 8 karakter)
        if (strlen($password) >= 8) {
            // Jika username belum digunakan dan password sesuai persyaratan, simpan data ke database
            $query = "INSERT INTO users (`Username`, `Password`) VALUES ('$username', '$password')";
            $result = mysqli_query($connect, $query);

            if ($result) {
                echo '<script>alert("Registrasi berhasil! Silakan login.");</script>';
                header('Location: login.php'); // Redirect ke halaman login setelah registrasi berhasil
                exit(); // Hentikan eksekusi script setelah redirect
            } else {
                echo '<script>alert("Registrasi gagal. Silakan coba lagi.");</script>';
            }
        } else {
            echo '<script>alert("Password harus minimal 8 karakter.");</script>';
        }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    <h1>Register to ShortLink</h1>
    <form method="POST">
        <input type="text" name="Username" placeholder="Username" required>
        <br>
        <input type="password" name="Password" placeholder="Password" required>
        <br>
        <input type="submit" name="Register" value="Register">
    </form>
</body>
</html>
