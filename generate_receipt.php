<?php
session_start();
require('fpdf186/fpdf.php');

if (!isset($_SESSION['elder_id']) || !isset($_GET['payment_id'])) {
    die("Invalid request. Please log in first.");
}

$elder_id = $_SESSION['elder_id'];
$payment_id = $_GET['payment_id'];

$conn = new mysqli("localhost", "root", "Smita@03", "geriatric_care");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT e.username, e.age, e.phone_no, e.email, e.address, e.medical_condition,
        p.payment_id, p.amount, p.payment_date, p.payment_method, p.payment_status
        FROM payment p 
        JOIN elder_info e ON p.elder_id = e.elder_id
        WHERE p.payment_id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Generate Receipt No. (Format: RCPT-<Payment ID>)
$receipt_no = "RCPT-" . str_pad($row['payment_id'], 6, '0', STR_PAD_LEFT);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, "Payment Receipt", 1, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10);

$pdf->Cell(50, 10, "Receipt No.:", 1);
$pdf->Cell(140, 10, $receipt_no, 1, 1);
$pdf->Cell(50, 10, "Name:", 1);
$pdf->Cell(140, 10, $row['username'], 1, 1);
$pdf->Cell(50, 10, "Age:", 1);
$pdf->Cell(140, 10, $row['age'], 1, 1);
$pdf->Cell(50, 10, "Phone:", 1);
$pdf->Cell(140, 10, $row['phone_no'], 1, 1);
$pdf->Cell(50, 10, "Email:", 1);
$pdf->Cell(140, 10, $row['email'], 1, 1);
$pdf->Cell(50, 10, "Address:", 1);
$pdf->MultiCell(140, 10, $row['address'], 1);
$pdf->Cell(50, 10, "Amount:", 1);
$pdf->Cell(140, 10, $row['amount'] . ' /-', 1, 1);
$pdf->Cell(50, 10, "Payment Date:", 1);
$pdf->Cell(140, 10, $row['payment_date'], 1, 1);

$pdf->Output("D", "Payment_Receipt_" . $receipt_no . ".pdf");

exit();
?>
