<?php
include 'config.php';

if (!isset($_POST['appointment_id'])) {
    die("Error: Appointment ID missing.");
}

$appointment_id = $_POST['appointment_id'];

$sql = "UPDATE appointment_slots SET is_booked = 1 WHERE appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointment_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
