<?php
// Database connection
$host = 'image-db.cp0wuao8ky1o.ap-south-1.rds.amazonaws.com';
$dbname = 'user_db';
$user = 'root';
$password = 'pass1234';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $username, $email, $password]);

        echo "Registration successful!";
          // Redirect to login page after successful registration
        header("Location: login.html");
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
