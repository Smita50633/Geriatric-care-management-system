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

// Check if caretaker is logged in
if (!isset($_SESSION['caretaker_id'])) {
    die("Unauthorized access! Please log in.");
}

$id = $_SESSION['caretaker_id'];

// Fetch caretaker profile details
$sql = "SELECT * FROM caretaker_info WHERE caretaker_id = ?";
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
    $username = trim($_POST['name']);
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone_no = trim($_POST['contact']);
    $shift = trim($_POST['shift']);
    $gender = trim($_POST['gender']);
    $qualification = trim($_POST['qualification']);
    $location = trim($_POST['location']);
    
    if ($age === false || !$email) {
        echo "<script>alert('Invalid input! Please enter valid age and email.');</script>";
    } else {
        $updateSql = "UPDATE caretaker_info SET username=?, age=?, email=?, phone_no=?, shift=?, gender=?, qualification=?, location=? WHERE caretaker_id=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sissssssi", $username, $age, $email, $phone_no, $shift, $gender, $qualification, $location, $id);

        if ($updateStmt->execute()) {
            echo "<script>alert('Profile updated successfully!'); window.location.href='caretakerdashboard.php';</script>";
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
    <title>My Profile</title>
    <style>
                :root {
  --primary-color: #12ac8e;
  --primary-color-dark: #0d846c;
  --primary-color-light: #e9f7f7;
  --secondary-color: #fb923c;
  --text-dark: #333333;
  --text-light: #767268;
  --white: #ffffff;
  --max-width: 1200px;
}
        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--primary-color-light);
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .header {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            height: 9%;
            z-index: 1000;
        }
        
        .nav__container {
            padding: 2rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
          }
        .nav__logo span {
            color: var(--secondary-color);
          }
        

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 6px;
            padding: 0;
            margin-left: -10%;
        }
        .navbar ul li {
          margin-left:20px;
        }
        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
            
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar ul li a:hover {
            background-color: var(--primary-color-dark);
        }

        .nav__logo {
          font-size: 1.8rem;
          font-weight: 700;
          color: var(--white);
        }
        

        /* Navbar styles */
        .navbar {
            display: flex;
            align-items: center;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .navbar ul li {
            display: inline-block;
            margin-left:-50%;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar ul li a:hover {
            background-color: #fb923c;
        }

        /* Footer */
        footer {
            background: #0d846c;
            color: white;
            padding: 10px;
            text-align: center;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }


        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fb923c;
        }
        
        .profile-container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            padding-bottom:5px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            margin-left:10px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            margin-left:10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        select {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            margin-left:10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            display: block;
            width: 50%;
            padding: 15px;
            margin: 20px 0;
            margin-left:25%;
            background: linear-gradient(135deg, #0d846c, #0d846c);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: linear-gradient(135deg, #12ac8e, #12ac8e);
        }
    
   </style>
</head>
<body>
<header class="header">
        <nav class="section__container nav__container">
            <div class="nav__logo">Geriatric<span>Care</span></div>
        
             
        </nav>

        <nav class="navbar">
            <ul>
                <li><a href="caretakerdashboard.php">BACK</a></li>
            </ul>
        </nav>
    </header>
    <br><br><br><br>

<center><h2 style="color:#fb923c">My Profile</h2></center>

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

        <label for="shift">Shift:</label>
        <input type="text" name="shift" id="shift" value="<?php echo htmlspecialchars($row['shift']); ?>">

        <label for="gender">Gender:</label>
        <select name="gender" id="gender">
            <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo ($row['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
        </select>

        <label for="qualification">Qualification:</label>
        <input type="text" name="qualification" id="qualification" value="<?php echo htmlspecialchars($row['qualification']); ?>">

        <label for="location">Location:</label>
        <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($row['location']); ?>">

        <button type="submit" name="save">Save Changes</button>
    </form>

</div>

</body>
</html>
