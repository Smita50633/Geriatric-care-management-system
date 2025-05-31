<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "Smita@03";
$db = "geriatric_care";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['elder_id'])) {
    die("Unauthorized access.");
}

$elder_id = $_SESSION['elder_id'];
$type = $_POST['type'] ?? '';

if ($type == "health") {
    $sql = "SELECT hr.record_date, hr.description, d.username AS doctor_name 
            FROM health_record hr
            JOIN doctor d ON hr.doctor_id = d.doctor_id
            WHERE hr.elder_id = ?
            ORDER BY hr.record_date DESC";
} elseif ($type == "appointment") {
    $sql = "SELECT a.appointment_date, d.username AS doctor_name, d.phone_no, a.reason
            FROM appointment a
            JOIN doctor d ON a.doctor_id = d.doctor_id
            WHERE a.elder_id = ?
            ORDER BY a.appointment_date DESC";
} elseif ($type == "medication") {
    $sql = "SELECT m.med_name, m.dosage, m.frequency, m.start_date, m.end_date
            FROM medication m
            WHERE m.elder_id = ?
            ORDER BY m.start_date DESC";
} else {
    die("Invalid request.");
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $elder_id);
$stmt->execute();
$result = $stmt->get_result();

// Return the table dynamically
echo "<h2>" . ucfirst($type) . " Details</h2>";
echo "<table border='1'><tr>";

// Table Headers
// if ($type == "health") {
//     echo "<th>Record Date</th><th>Description</th><th>Doctor Name</th>";}
 if ($type == "appointment") {
    echo "<th>Appointment Date</th><th>Doctor Name</th><th>Phone No</th><th>Reason</th>";
} elseif ($type == "medication") {
    echo "<th>Tablet Name</th><th>Dosage</th><th>Frequency</th><th>Start Date</th><th>End Date</th>";
}
echo "</tr>";

// Fetch and display data
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>" . htmlspecialchars($value) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

$stmt->close();
$conn->close();
?>
