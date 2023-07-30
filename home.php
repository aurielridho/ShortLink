<!DOCTYPE html>
<html>
<head>
<title>ShortLink - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
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
        p {
            margin: 15px 0;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>ShortLink - URL Shortener</h1>
    <form method="post" action="">
        <label for="original_url">Enter your long URL:</label>
        <input type="text" name="original_url" id="original_url" required>
        <br>
        <label for="short_code">Custom short slug (optional):</label>
        <input type="text" name="short_code" id="short_code">
        <br>
        <input type="submit" value="Shorten">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $original_url = $_POST['original_url'];
        $short_code = $_POST['short_code'];

        // Validate the URL
        if (filter_var($original_url, FILTER_VALIDATE_URL)) {
            // If the custom short slug is empty, generate a random short code
            if (empty($short_code)) {
                $short_code = generateShortCode();
            }

            // Database connection
            $connect = mysqli_connect("localhost", "root", "", "ShortLink");

            if (!$connect) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if the short code is already in use
            $query = "SELECT * FROM short_urls WHERE short_code = '$short_code'";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "Custom short slug is already in use. Please choose a different one.";
            } else {
                // Save the original URL and short code in the database
                $query = "INSERT INTO short_urls (original_url, short_code, visit_count) VALUES ('$original_url', '$short_code', 0)";
                $result = mysqli_query($connect, $query);

                if ($result) {
                    $shortened_url = "http://your_web_domain.com/$short_code"; // Replace 'your_web_domain.com' with your actual domain
                    echo "<div class='shortened-url'>";
                    echo "<h2>Shortened URL:</h2>";
                    echo "<p>Short URL: <a href='$original_url'><your_web_domain>$shortened_url</a></p>";
                    echo "<ul><li>Original URL: <a href='$original_url'>$original_url</a></li>";
                    echo "<li>Visits: 0</li></ul>"; // Visits initialized to 0
                    echo "</div>";
                } else {
                    echo "Error saving data: " . mysqli_error($connect);
                }
            }

            mysqli_close($connect);
        } else {
            echo "Invalid URL. Please enter a valid URL.";
        }
    }

    // Function to generate a random short code
    function generateShortCode() {
        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $short_code = '';

        for ($i = 0; $i < $length; $i++) {
            $random_index = mt_rand(0, strlen($characters) - 1);
            $short_code .= $characters[$random_index];
        }

        return $short_code;
    }
    ?>

    <?php
    // Database connection
    $connect = mysqli_connect("localhost", "root", "", "ShortLink");

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve the list of shortened URLs and visit counts from the database
    $query = "SELECT * FROM short_urls ORDER BY id DESC LIMIT 1"; // Get the latest shortened URL
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $short_code = $row['short_code'];
        $original_url = $row['original_url'];
        $visit_count = $row['visit_count'];
    } else {
        echo "<div class='shortened-url'>";
        echo "<h2>Latest Shortened URL:</h2>";
        echo "<p>No shortened URLs found.</p>";
        echo "</div>";
    }

    mysqli_close($connect);
    ?>
</body>
</html>
