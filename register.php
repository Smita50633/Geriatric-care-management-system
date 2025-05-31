<?php
$servername = "localhost";
$username = "root";
$password = "Smita@03";
$database = "geriatric_care";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST variables are set
$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$role = isset($_POST['role']) ? htmlspecialchars($_POST['role']) : ''; 
$gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : '';
$dob = isset($_POST['age']) ? htmlspecialchars($_POST['age']) : '';
// $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
$phone_no = isset($_POST['mobile_no']) ? htmlspecialchars($_POST['mobile_no']) : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';

// Allowed roles
$valid_roles = ["elder" => "elder_info", "caretaker" => "caretaker_info", "doctor" => "doctor"];

// Validate role
if (!array_key_exists($role, $valid_roles)) {
    die("Invalid role selected.");
}

$table_name = $valid_roles[$role];

// Check if required fields are not empty
if (empty($username) || empty($role) || empty($gender) || empty($dob) || empty($phone_no) || empty($email) || empty($_POST['password'])) {
    die("Please fill all required fields.");
}
$sql = "INSERT INTO $table_name (username, gender, age, phone_no, email, password, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind only 6 parameters since created_at is handled by NOW()
$stmt->bind_param("ssssss", $username, $gender, $dob, $phone_no, $email, $password);


// Execute and handle response
if ($stmt->execute()) {
    echo "<script>alert('Registration Successful!'); window.location.href='loginpage.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
