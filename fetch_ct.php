<?php
include 'config.php'; // Ensure you have a working database connection

if (!isset($_GET['table'])) {
    die("Table name not provided.");
}

$tableName = mysqli_real_escape_string($conn, $_GET['table']); // Sanitize input
$caretaker_id = 1; // Replace with session-based user ID after implementing authentication

// Whitelist allowed table names to prevent SQL injection
$allowedTables = ['elder_info', 'medication', 'appointment_slots'];

if (!in_array($tableName, $allowedTables)) {
    die("Invalid table name.");
}

if ($tableName == 'elder_info') {
    $sql = "SELECT elder_id, username, age, medical_condition 
            FROM elder_info 
            WHERE elder_id IN 
            (SELECT assigned_elder_id FROM caretaker_info WHERE caretaker_id = ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $caretaker_id);
    $stmt->execute();
    $result = $stmt->get_result();
}

elseif ($tableName == 'medication') {
    $sql = "SELECT m.med_id, e.username AS elder_name, m.med_name, m.dosage, m.frequency, 
                   m.start_date, m.end_date, m.created_at 
            FROM medication m
            JOIN elder_info e ON m.elder_id = e.elder_id
            JOIN caretaker_info c ON e.elder_id = c.assigned_elder_id
            WHERE c.caretaker_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $caretaker_id);
    $stmt->execute();
    $result = $stmt->get_result();
}

elseif ($tableName == 'appointment_slots') {
    $sql = "SELECT a.appointment_id, d.username AS doctor_name, a.appointment_date, a.created_at
            FROM appointment_slots a
            JOIN doctor d ON a.doctor_id = d.doctor_id";

    $result = $conn->query($sql);
}

// Generate the HTML table if data exists
if ($result->num_rows > 0) {
    echo "<h2>" . ucfirst(str_replace('_', ' ', $tableName)) . " List</h2>";
    echo "<table border='1'><tr>";

    while ($field = $result->fetch_field()) {
        echo "<th>" . ucfirst(str_replace('_', ' ', $field->name)) . "</th>";
    }
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found in " . htmlspecialchars($tableName) . ".</p>";
}

$conn->close();
?>
