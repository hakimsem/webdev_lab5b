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

// Get the matric value from the URL
if (!isset($_GET['matric'])) {
    echo "Invalid request!";
    exit();
}

$matric = $_GET['matric'];

// Fetch user data for the given matric
$sql = "SELECT * FROM users WHERE matric = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "User not found!";
    exit();
}

$user = $result->fetch_assoc();

// Initialize success message
$successMessage = "";

// Update user data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];

    $updateSql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sss", $name, $role, $matric);

    if ($updateStmt->execute()) {
        $successMessage = "User updated successfully!";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
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
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: white;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            font-size: 28px;
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], select {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #45a049;
        }

        .success-message {
            color: green;
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .cancel-link a {
            background-color: #ccc;
            padding: 10px 20px;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
        }

        .cancel-link a:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <h2>Update User Information</h2>
    
    <!-- Display success message -->
    <?php if (!empty($successMessage)) : ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($user['matric']); ?>" readonly><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="student" <?php if ($user['role'] == 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if ($user['role'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br><br>

        <button type="submit">Update</button>
        <a href="display.php">Cancel</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
