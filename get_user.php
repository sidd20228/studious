<?php
session_start();
header('Content-Type: application/json');

$response = ['loggedIn' => false];

if (isset($_SESSION['username'])) {
    // Database configuration
    $servername = "localhost";  // Typically 'localhost'
    $database = "your_database_name"; // Your database name
    $username = "root"; // Your database username
    $password = ""; // Your database password

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
    }

    $user = $_SESSION['username'];
    $query = "SELECT name, dob FROM users WHERE username='$user'";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $response = [
            'loggedIn' => true,
            'name' => $user['name'],
            'dob' => $user['dob']
        ];
    }

    $conn->close();
}

echo json_encode($response);
?>
