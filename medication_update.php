<?php
session_start();

// Check if caretaker is logged in
if (!isset($_SESSION['caretaker_id'])) {
    die("Access denied. Please log in as a caretaker.");
}

$caretaker_id = $_SESSION['caretaker_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $med_name = trim($_POST['med_name']);
    $frequency = trim($_POST['frequency']);
    $dosage = trim($_POST['dosage']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $elder_id = $_SESSION['elder_id'] ?? null; // Ensure elder ID is available

    if ($elder_id) {
      $sql = "INSERT INTO medication (elder_id, med_name, frequency, dosage, start_date, end_date) 
      VALUES (?, ?, ?, ?, ?, ?) 
      ON DUPLICATE KEY UPDATE med_name = VALUES(med_name), 
                              frequency = VALUES(frequency), 
                              dosage = VALUES(dosage), 
                              start_date = VALUES(start_date), 
                              end_date = VALUES(end_date)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $elder_id, $med_name, $frequency, $dosage, $start_date, $end_date);

        if ($stmt->execute()) {
            echo "<script>alert('Medication details updated successfully!'); window.location.href='caretakerdashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating medication details.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Elder ID not found.');</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medical Details</title>
    <style>
        :root {
            --primary-color: #12ac8e;
            --primary-color-dark: #0d846c;
            --primary-color-light: #e9f7f7;
            --secondary-color: #fb923c;
            --text-dark: #333333;
            --white: #ffffff;
        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--primary-color-light);
            margin: 0;
            padding: 0;
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

        .nav__logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
        }

        .nav__logo span {
            color: var(--secondary-color);
        }

        .navbar ul {
            list-style: none;
            display: flex;
            padding: 0;
        }

        .navbar ul li {
            margin-right: 30px;
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

        .auth-container {
            max-width: 400px;
            margin: 120px auto;
            padding: 30px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .auth-container input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .btn {
            width: 50%;
            padding: 12px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: var(--primary-color-dark);
        }
    </style>
</head>
<body>
<header class="header">
    <div class="nav__logo">Geriatric<span>Care</span></div>
    <nav class="navbar">
        <ul>
            <li><a href="caretakerdashboard.php">BACK</a></li>
        </ul>
    </nav>
</header>

<div class="auth-container">
    <h2>Update Medical Details</h2>
    <form method="post">
        <label>Medicine Name:</label><br>
        <input type="text" name="med_name" required><br>

        <label>Frequency:</label><br>
        <input type="text" name="frequency" required><br>

        <label>Dosage:</label><br>
        <input type="text" name="dosage" required><br>

        <label>Start Date:</label><br>
        <input type="date" name="start_date" required><br>

        <label>End Date:</label><br>
        <input type="date" name="end_date"><br>

        <button type="submit" class="btn">Update</button>
    </form>
</div>
</body>
</html>
