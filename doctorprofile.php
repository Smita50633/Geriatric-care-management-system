<?php
session_start();
session_regenerate_id(true); // Security improvement

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = '';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    die("Unauthorized access! Please log in.");
}

$id = $_SESSION['doctor_id'];

// Fetch doctor profile details
$sql = "SELECT * FROM doctor WHERE doctor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No profile found!";
    exit();
}

// Handle profile update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $name = trim($_POST['username']);
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone_no = trim($_POST['phone_no']);
    $specialization = trim($_POST['specialization']);
    $gender = trim($_POST['gender']);
   
   
    
    if ($age === false || !$email) {
        echo "<script>alert('Invalid input! Please enter valid age and email.');</script>";
    } else {
        $updateSql = "UPDATE doctor SET username=?, age=?, email=?, phone_no=?, specialization=?, gender=? WHERE doctor_id=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sissssi", $name, $age, $email, $phone_no, $specialization, $gender,$id);

        if ($updateStmt->execute()) {
            echo "<script>alert('Profile updated successfully!'); window.location.href='doctordashboard.php';</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $updateStmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Profile</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f0f4f8; }
        h1 { text-align: center; margin-bottom: 20px; color: #3949ab; }
        .profile-container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 20px 0;
            background: linear-gradient(135deg, #5c6bc0, #3949ab);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover { background: linear-gradient(135deg, #7986cb, #5c6bc0); }
        .back-btn { text-align: center; margin-top: 10px; }
        .back-btn a { text-decoration: none; color: #3949ab; font-weight: bold; }
    </style>
</head>
<body>

<h1>Doctor Profile</h1>

<div class="profile-container">
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($row['username']); ?>" required>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" value="<?php echo $row['age']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

        <label for="contact">Contact Number:</label>
        <input type="tel" name="contact" id="contact" value="<?php echo htmlspecialchars($row['phone_no']); ?>" required>

        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" id="specialization" value="<?php echo htmlspecialchars($row['specialization']); ?>">

        <label for="gender">Gender:</label>
        <select name="gender" id="gender">
            <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo ($row['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
        </select>

        
        <button type="submit" name="save">Save Changes</button>
    </form>

    <div class="back-btn">
        <a href="doctordashboard.php">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
