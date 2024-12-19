<?php
session_start(); // Start session

// Check if the user is logged in
if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_5b"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the matric value is provided
if (!isset($_GET['matric'])) {
    echo "Invalid request!";
    exit();
}

$matric = $_GET['matric'];

// Delete the user with the given matric
$sql = "DELETE FROM users WHERE matric = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric);

if ($stmt->execute()) {
    header("Location: display.php?success=delete");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #d9534f;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .message {
            color: #5bc0de;
            font-size: 18px;
            margin-bottom: 25px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .buttons a, .buttons button {
            background-color: #5bc0de;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .buttons a:hover, .buttons button:hover {
            background-color: #31b0d5;
        }

        .buttons a {
            background-color: #f0ad4e;
            color: white;
        }

        .buttons a:hover {
            background-color: #ec971f;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Delete User</h2>

        <?php if ($success) : ?>
            <p class="message">User has been successfully deleted!</p>
        <?php else : ?>
            <p class="message">An error occurred while trying to delete the user. Please try again.</p>
        <?php endif; ?>

        <div class="buttons">
            <a href="display.php">Back to User List</a>
        </div>
    </div>

</body>
</html>
