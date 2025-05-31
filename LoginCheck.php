<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = mysqli_connect("localhost", "root", "Smita@03", "geriatric_care");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Collect form data safely
$role = isset($_POST['role']) ? trim($_POST['role']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Store input temporarily to retain values after failed login
$_SESSION['role_temp'] = $role;
$_SESSION['username_temp'] = $username;

// Hardcoded Admin Login (if passwords are not hashed)
if ($role === "admin" && $username === "admin" && $password === "password") {
    $_SESSION['role'] = "admin";
    $_SESSION['username'] = "admin";
    header("Location: admin.php");
    exit();
}

// Allowed roles mapping (Database Table Names)
$valid_roles = [
    "elder" => "elder_info",
    "caretaker" => "caretaker_info",
    "doctor" => "doctor"
];

// Validate role
if (!array_key_exists($role, $valid_roles)) {
    $_SESSION['login_error'] = "Invalid Username or Password"; 
    header("Location: loginpage.php");
    exit();
}

// Get the table name
$table_name = $valid_roles[$role];

// Prepare SQL query
$query = "SELECT * FROM $table_name WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("SQL Error: " . mysqli_error($conn));
}

// Bind parameters and execute query
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if user exists
if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    // Verify the password (hashed password check)
    if (password_verify($password, $row['password'])) { 
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $username;
        $_SESSION[$role . '_id'] = $row[$role . '_id']; // Store user ID
        header("Location: {$role}dashboard.php");
        exit();
    }
}

// Store error message and redirect
$_SESSION['login_error'] = "Invalid Username or Password"; 
header("Location: loginpage.php");
exit();

// Close resources
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
