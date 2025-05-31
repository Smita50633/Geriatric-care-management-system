<?php
include 'config.php';

if (!isset($_GET['table'])) {
    die("Error: Table parameter missing.");
}

$table = $_GET['table'];

if ($table == "elder_info") {
    // Fetch elder details
    $sql = "SELECT elder_id, username, age, gender, address, phone_no, email, medical_condition, diet_restriction FROM elder_info";
} else if ($table == "appointment_slots") {
    // Fetch appointment slots with doctor name
    $sql = "SELECT a.appointment_id, d.username AS doctor_name, a.appointment_date 
            FROM appointment_slots a 
            JOIN doctor d ON a.doctor_id = d.doctor_id 
            WHERE a.is_booked = 0";
} else {
    $sql = "SELECT * FROM $table";
}

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Display table headers
echo "<table border='1'><tr>";
while ($field = $result->fetch_field()) {
    echo "<th>{$field->name}</th>";
}

// Add extra column headers for actions
if ($table == "elder_info") {
    echo "<th>Update Medical Details</th>";
} elseif ($table == "appointment_slots") {
    echo "<th>Action</th>";
}
echo "</tr>";

// Loop through results and display rows
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>{$value}</td>";
    }

    // If elder_info table, add "Update Medical Details" button
    if ($table == "elder_info") {
        echo "<td><button onclick='updateMedicalDetails({$row['elder_id']})' style='background-color: #fb923c; color: white; border: none;padding:5px;border-radius:5px'>Update</button></td>";
    }

    // If appointment slots, add a "Book" button
    if ($table == "appointment_slots") {
        echo "<td><button onclick='confirmAppointment({$row['appointment_id']})' style='background-color: #fb923c; color: white; border: none;padding:5px;border-radius:5px'>Confirm</button></td>";
    }

    echo "</tr>";
}

echo "</table>";

$conn->close();
?>
