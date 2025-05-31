<?php
session_start();

// Check if the elder is logged in
if (!isset($_SESSION['elder_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='loginpage.php';</script>";
    exit();
}

$elder_id = $_SESSION['elder_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <link rel="stylesheet" href="adminstyle.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f5f5f5; }
        .payment-box { background: white; padding: 20px 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 350px; text-align: center; }
        label { display: block; margin-top: 15px; font-size: 16px; color: #333; }
        input{ width: 90%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button {width: 50%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        select{width: 95%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button { margin-top: 20px; background: #0d846c; color: white; border: none; font-size: 18px; cursor: pointer; }
        button:hover { background: #12ac8e; }
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
            background-color: #01624e;
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
<div class="payment-box">
    <h2>Make Payment</h2>
    <form action="process_payment.php" method="POST">
        <label for="elder_id">Elder ID:</label>
        <input type="number" id="elder_id" name="elder_id" value="<?php echo htmlspecialchars($elder_id); ?>" readonly>
        
        <label for="amount">Amount (₹):</label>
        <input type="number" id="amount" name="amount" required>
        
        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method">
            <option value="Credit/Debit Card">Credit/Debit Card</option>
            <option value="Net Banking">Net Banking</option>
            <option value="UPI">UPI</option>
        </select>
    
        <button type="submit">Pay</button>
    </form>
</div>

</body>
</html>
