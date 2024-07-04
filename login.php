<?php
session_start(); // Start session to access session variables

header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "your_database_name"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get the posted data
$postData = file_get_contents("php://input");
$request = json_decode($postData);

$username = $request->username;
$password = $request->password;

// Verify user credentials
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Password is correct, login successful
        $_SESSION['username'] = $username; // Store username in session

        echo json_encode(['success' => true, 'message' => 'Login successful.']);
    } else {
        // Password is incorrect
        echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
    }
} else {
    // Username not found
    echo json_encode(['success' => false, 'message' => 'Username not found.']);
}

$stmt->close();
$conn->close();
?>
