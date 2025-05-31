<?php
// Database connection
$conn = new mysqli("localhost", "root", "Smita@03", "geriatric_care");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Insert data into the database
$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "User registered successfully! <br><br><a href='login.html'>Login here</a>";
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
