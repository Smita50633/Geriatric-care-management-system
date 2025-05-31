<?php
session_start();
include 'config.php'; // Ensure you have a connection file

// Check if the doctor is logged in
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
        echo "<script>alert('Availability submitted successfully!');</script>";
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html, body {
            width: 100%;
            height: 100vh;
            background-color: #f5f5f5;
        }

        /* Header styles */
        .header {
            display: flex;
            position: fixed;
            height: 12%;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding: 10px 8px;
            background-color: #0077b6;
            color: white;
            top: 0;
        }

        .logo img {
            width: 80px;
            border-radius: 50%;
        }

        .title h2 {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar ul li a:hover {
            background-color: #03045e;
        }

        .container {
            max-width: 600px;
            margin: 15% auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        footer {
            background: #0077b6;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <script>
        function toggleForm() {
            var form = document.getElementById("availabilityForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <header>
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
    </header>

    <div class="container">
        <h2>Set Your Availability</h2>
        <button onclick="toggleForm()">Availability</button>
        <div id="availabilityForm" style="display: none;">
            <form method="POST">
                <label for="avail_date" style="margin-top:10px">Available Date:</label>
                <input type="date" name="avail_date" value="<?= date('Y-m-d') ?>" required>
                <label for="avail_time" style="margin-top:10px">Available Time:</label>
                <input type="time" name="avail_time" value="<?= date('H:i') ?>" required>
                <button type="submit">Submit Availability</button>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2025 Geriatric Care Management System
    </footer>
</body>
</html>