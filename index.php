<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShortLink</title>
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
        a {
            text-decoration: none;
            display: inline-block;
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        }
        .login-btn {
            background-color: #28A745;
        }
        .register-btn {
            background-color: #FFC107;
        }
    </style>
</head>
<body>
    <h1>Welcome To Shortlink</h1>
    <a href="login.php">
        <button class="login-btn">Login</button>
    </a>
    <a href="register.php">
        <button class="register-btn">Register</button>
    </a>
</body>
</html>