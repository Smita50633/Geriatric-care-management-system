<?php
include 'config.php';

$table = $_GET['table'];

if ($table == "appointment_slots") {
    $sql = "SELECT a.appointment_id, d.username AS doctor_name, a.appointment_date 
            FROM appointment_slots a 
            JOIN doctor d ON a.doctor_id = d.doctor_id 
            WHERE a.is_booked = 0";
} else {
    $sql = "SELECT * FROM $table";
}

$result = $conn->query($sql);
echo "<table><tr>";
while ($field = $result->fetch_field()) {
    echo "<th>{$field->name}</th>";
}
echo "</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>{$value}</td>";
    }
    if ($table == "appointment_slots") {
        echo "<td><button onclick='confirmAppointment({$row["appointment_id"]})'>Book</button></td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
