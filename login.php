<?php
session_start();

// Database configuration
$host = 'image-db.cp0wuao8ky1o.ap-south-1.rds.amazonaws.com';
$db = 'user_db';
$user = 'root';
$pass = 'pass1234';

// Create a new mysqli instance
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_username, $db_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $db_password)) {
            // Password is correct, set session and redirect to dashboard
            $_SESSION['user_id'] = $user_id;
            header("Location: dashboard.php");
            exit;
        } else {
            // Password is incorrect
            header("Location: login.html?error=1");
            exit;
        }
    } else {
        // No user found with that username/email
        header("Location: login.html?error=1");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
