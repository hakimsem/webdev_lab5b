<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "";     // Replace with your DB password
$dbname = "lab_5b"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash the password
    $role = $_POST['role'];

    // Insert data into database
    $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
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
            max-width: 480px;
            margin: 60px auto;
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

        input,
        select {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border 0.3s ease;
        }

        input:focus,
        select:focus {
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
    </style>
</head>

<body>
    <h2>Register</h2>
    <form method="POST" action="register.php">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required><br>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="">Please select</option>
            <option value="Student">Student</option>
            <option value="Lecturer">Lecturer</option>
        </select><br>
        
        <button type="submit">Submit</button>
    </form>
    <p> <a href="login.php">Login</a> here if you done</p>
</body>
</html>
