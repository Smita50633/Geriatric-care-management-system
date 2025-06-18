<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['elder_id'], $_POST['amount'], $_POST['payment_method'])) {
        die("Invalid request. Missing required fields.");
    }

    $elder_id = intval($_POST['elder_id']); // Ensure integer type
    $amount = floatval($_POST['amount']); // Ensure numeric value
    $payment_method = trim($_POST['payment_method']); // Remove extra spaces
    $payment_date = date('Y-m-d H:i:s');

    // Validate input data
    if ($elder_id <= 0 || $amount <= 0 || empty($payment_method)) {
        die("Invalid input data.");
    }

    // Database connection
    $conn = new mysqli("localhost", "root", "", "");
    
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Insert payment details
    $sql = "INSERT INTO payment (elder_id, amount, payment_method, payment_date, payment_status) 
            VALUES (?, ?, ?, ?, 'Completed')";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("SQL Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("idss", $elder_id, $amount, $payment_method, $payment_date);

    if ($stmt->execute()) {
        $_SESSION['payment_message'] = "Payment of ₹" . number_format($amount, 2) . " was successful!";
        $_SESSION['payment_amount'] = $amount;
        $_SESSION['payment_date'] = $payment_date;
        $_SESSION['payment_method'] = $payment_method;

        header("Location: payment_acknowledgement.php");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request method.");
}
?>
