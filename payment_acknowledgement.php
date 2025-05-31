<?php
session_start();

if (!isset($_SESSION['elder_id'])) {
    die("Invalid request. Please log in first.");
}

$elder_id = $_SESSION['elder_id'];

$conn = new mysqli("localhost", "root", "Smita@03", "geriatric_care");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT p.payment_id, p.amount, p.payment_date, p.payment_method, p.payment_status, e.username
        FROM payment p 
        JOIN elder_info e ON p.elder_id = e.elder_id
        WHERE p.elder_id = ?
        ORDER BY p.payment_date DESC LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $elder_id);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc() ?: null; // If no record found, set to null

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Acknowledgment</title>
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2rem 1rem;
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
            margin: 0;
        }

        .navbar ul li {
            margin-left: -35%;
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

        .container {
            max-width: 440px;
            margin: 8% auto;
            padding: 20px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: var(--primary-color-dark);
        }

        p {
            font-size: 18px;
        }

        .button-container {
            margin-top: 20px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            margin: 5px;
        }

        .green {
            background-color: var(--primary-color-dark);
            color: white;
        }

        .blue {
            background-color: var(--secondary-color);
            color: white;
        }

        button:hover {
            opacity: 0.8;
        }

        .footer {
            background: var(--primary-color-dark);
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 13.9%;
           
        
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
            <li><a href="elderdashboard.php">BACK</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php if ($row): ?>
        <h2>Payment Successful!</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
        <p><strong>Amount Paid:</strong> ₹<?php echo number_format($row['amount'], 2); ?></p>
        <p><strong>Date & Time:</strong> <?php echo htmlspecialchars($row['payment_date']); ?></p>
        <p><strong>Method:</strong> <?php echo htmlspecialchars($row['payment_method']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($row['payment_status']); ?></p>
        <div class="button-container">
            <button class="blue" onclick="window.location.href='payment_history.php'">View History</button>
            <button class="green" onclick="window.location.href='generate_receipt.php?payment_id=<?php echo $row['payment_id']; ?>'">Download Receipt</button>
        </div>
    <?php else: ?>
        <h2>No Recent Payment Found</h2>
        <p>Please make a payment first.</p>
        <button class="green" onclick="window.location.href='payment_page.php'">Make a Payment</button>
    <?php endif; ?>
</div>

<footer class="footer">
    &copy; <?php echo date("Y"); ?> Copyright © 2025 Geriatric Management System. All rights reserved.
</footer>

</body>
</html>
