<?php
// Start session to track logged-in users
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Database credentials
$servername = "localhost"; // Change if using a remote database
$username = "root";        // MySQL username (default for XAMPP)
$password = "Smita@03";            // MySQL password (default is empty for XAMPP)
$database = "geriatric_care"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
