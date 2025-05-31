<?php
session_start();
$conn = new mysqli("localhost", "root", "Smita@03", "geriatric_care");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role = $id = "";
$record = null;
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['get_data'])) {
    $role = $_POST['role'] ?? "";
    $id = $_POST['id'] ?? "";

    if (!empty($role) && !empty($id)) {
        switch ($role) {
            case "elder":
                $sql = "SELECT e.username AS elder_name, e.medical_condition, e.email, e.phone_no, 
                               c.username AS caretaker_name 
                        FROM elder_info e 
                        LEFT JOIN caretaker_info c ON e.elder_id = c.assigned_elder_id 
                        WHERE e.elder_id = ?";
                break;
            case "caretaker":
                $sql = "SELECT c.username AS caretaker_name, c.location, c.email, c.phone_no, 
                               e.username AS assigned_elder 
                        FROM caretaker_info c 
                        LEFT JOIN elder_info e ON c.assigned_elder_id = e.elder_id 
                        WHERE c.caretaker_id = ?";
                break;
            case "doctor":
                $sql = "SELECT d.username AS doctor_name, d.specialization, d.email, d.phone_no 
                        FROM doctor d 
                        WHERE d.doctor_id = ?";
                break;
            default:
                $error_message = "Invalid role selection.";
                break;
        }

        if (isset($sql)) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $record = $result->fetch_assoc();
            } else {
                $error_message = "No record found for the given ID.";
            }
            $stmt->close();
        }
    } else {
        $error_message = "Please select a role and enter a valid ID.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $role = $_POST['role'];
    $id = $_POST['id'];

    if ($role == "elder") {
        // Delete appointments first to avoid foreign key constraint issue
        $delete_appointments = $conn->prepare("DELETE FROM appointment_slots WHERE elder_id = ?");
        $delete_appointments->bind_param("i", $id);
        $delete_appointments->execute();
        $delete_appointments->close();

        // Now delete elder record
        $delete_sql = "DELETE FROM elder_info WHERE elder_id = ?";
    } elseif ($role == "caretaker") {
        $delete_sql = "DELETE FROM caretaker_info WHERE caretaker_id = ?";
    } elseif ($role == "doctor") {
        $delete_sql = "DELETE FROM doctor WHERE doctor_id = ?";
    } else {
        $error_message = "Invalid role selection.";
    }

    if (isset($delete_sql)) {
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "Record deleted successfully.";
            $role = $id = "";
            $record = null;
        } else {
            $error_message = "Error deleting record. Please try again.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
    <!-- <link rel="stylesheet" href="styles1.css"> -->
    <style>
        :root {
    --primary-color: #12ac8e;
    --primary-color-dark: #0d846c;
    --primary-color-light: #e9f7f7;
    --secondary-color: #fb923c;
    --text-dark: #333333;
    --text-light: #767268;
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

.nav__container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.nav__logo {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--white);
}

.navbar ul {
    list-style: none;
    display: flex;
    gap: 2px;
}
.navbar ul li{
    margin-left:-40%;
}
.navbar ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.navbar ul li a:hover {
    background-color: var(--primary-color-dark);
}

.container {
    max-width: 400px;
    margin: 10% auto;
    padding: 30px;
    background: var(--white);
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.auth-container {
            max-width: 400px;
            margin: 10% auto;
            padding: 30px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .auth-container   input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .auth-container  select{
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 10px;
        }

.success {
    color: green;
    font-weight: bold;
}

.error {
    color: red;
    font-weight: bold;
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
    <nav class="section__container nav__container">
        <div class="nav__logo">Geriatric<span>Care</span></div>
    </nav>
    <nav class="navbar">
        <ul>
            <li><a href="admin.php">BACK</a></li>
        </ul>
    </nav>
</header>

<div class="auth-container">
    <h2>Delete Record</h2>

  

    <form method="post" action="">
        <select id="role" name="role" required>
            <option value="">--Select Role--</option>
            <option value="elder" <?= ($role == "elder") ? "selected" : "" ?>>Elder</option>
            <option value="caretaker" <?= ($role == "caretaker") ? "selected" : "" ?>>Caretaker</option>
            <option value="doctor" <?= ($role == "doctor") ? "selected" : "" ?>>Doctor</option>
        </select>
        <input type="number" name="id" value="<?= htmlspecialchars($id) ?>" required placeholder="Enter ID">
        <button type="submit" class="btn" name="get_data">Get Data</button>
    </form>
    <?php if ($record): ?>
        <h3>Record Details</h3>
        <?php foreach ($record as $key => $value): ?>
            <p><strong><?= ucfirst(str_replace("_", " ", $key)) ?>:</strong> <?= htmlspecialchars($value) ?></p>
        <?php endforeach; ?>

        <form method="post" action="">
            <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <button type="submit" class="btn" name="delete" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <p class="success-message"><?= $success_message ?></p>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
    <?php endif; ?>
</div>
</body>
</html>
