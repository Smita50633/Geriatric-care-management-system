<?php
session_start();
include 'config.php'; // Ensure you have a connection file

// Check if the doctor is logged in (assuming doctor_id is stored in session)
if (!isset($_SESSION['doctor_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $avail_date = $_POST['avail_date'];
    $avail_time = $_POST['avail_time'];
    
    $sql = "INSERT INTO availability (avail_date, avail_time, doctor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $avail_date, $avail_time, $doctor_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Availability submitted successfully!'); window.location.href='doctor_availability.php';</script>";
    } else {
        echo "<script>alert('Error submitting availability. Try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor's Availability</title>
  
  <style>
     
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      text-align: center;
      padding: 50px;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .form-container {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      display: inline-block;
      width:300px;
    }
    input, button {
      padding: 10px;
      margin: 10px;
      
    }
    .footer {
      margin-top: auto;
      background-color: #0077b6;
      color: white;
      text-align: center;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>
<body>
<header>
    <div class="main">
      <div class="header">
        <div class="logo">
          <img src="LOGO.jpg" alt="Logo">
        </div>
        <div class="title">
          <h2>Geriatric Care Management System</h2>
        </div>
        <nav class="navbar">
          <ul>
            <li><a href="index.html">HOME</a></li>
            <li><a href="doctorprofile.php">My Profile</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

    <h2>Set Your Availability</h2>
    <div class="form-container">
        <form method="POST" action="">
            <label for="avail_date">Available Date:</label>
            <input type="date" name="avail_date" value="<?= date('Y-m-d') ?>" required>
            <br>
            <label for="avail_time">Available Time:</label>
            <input type="time" name="avail_time" value="<?= date('H:i') ?>" required>
            <br>
            <button type="submit">Submit Availability</button>
        </form>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Geriatric Care Management System. All rights reserved.</p>
    </footer>
</body>
</html>
