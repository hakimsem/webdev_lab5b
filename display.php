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

// Fetch users from the database
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
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
            width: 0%;
            max-width: 1000px;
            margin: 50px auto;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:hover td {
            background-color: #f1f1f1;
        }

        a {
            color: #4CAF50;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .logout a {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
        }

        .logout a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
    <h3>Users Information</h3>
    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['matric']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['role']) . "</td>
                         <td>
                            <a href='update.php?matric=" . urlencode($row['matric']) . "'>Update</a> |
                            <a href='delete.php?matric=" . urlencode($row['matric']) . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                        </td>
                        </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users found.</td></tr>";
        }
        ?>
    </table>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>

<?php
$conn->close();
?>
