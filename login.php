<?php
session_start(); // Start session

// Database connection
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['matric'] = $row['matric'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            header("Location: display.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this matric.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: #4CAF50;
            background-color: #fff;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #4CAF50;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="matric">Matric:</label><br>
        <input type="text" id="matric" name="matric" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
    <p> <a href="register.php">Register</a> here if you not</p>
</body>
</html>
