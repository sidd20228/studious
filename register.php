<?php
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
$name = $request->name;
$dob = $request->dob;

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if the username already exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already exists.']);
} else {
    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password, name, dob) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $hashedPassword, $name, $dob);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration successful.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }
}

$stmt->close();
$conn->close();
?>
