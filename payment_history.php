<?php
session_start();

if (!isset($_SESSION['elder_id'])) {
    die("Invalid request. Please log in first.");
}

$elder_id = $_SESSION['elder_id'];

$conn = new mysqli("localhost", "root", "", "");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT p.payment_id, p.amount, p.payment_date, p.payment_method, p.payment_status 
        FROM payment p 
        WHERE p.elder_id = ? 
        ORDER BY p.payment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $elder_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment History</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center;margin:0;height:100vh;}
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #0d846c; color: white; }
        button { padding: 5px 10px; font-size: 14px; background-color: #fb923c; color: white;border:none; border-radius: 2px; cursor: pointer; }
        
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
            background-color: #01624e;
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
            color: #0d846c;
        }    </style>
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

<br><br><br><br>
<h2>Payment History</h2>

<table>
    <tr>
        <th>Payment ID</th>
        <th>Amount (₹)</th>
        <th>Payment Date</th>
        <th>Method</th>
        <th>Status</th>
        <th>Download</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['payment_id']; ?></td>
            <td><?php echo number_format($row['amount'], 2); ?></td>
            <td><?php echo $row['payment_date']; ?></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td><?php echo $row['payment_status']; ?></td>
            <td><button onclick="window.location.href='generate_receipt.php?payment_id=<?php echo $row['payment_id']; ?>'">Download</button></td>
        </tr>
    <?php } ?>

</table>
<br><br>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
