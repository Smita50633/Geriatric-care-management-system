<?php
// Database connection
$conn = new mysqli("localhost", "root", "Smita@03", "geriatric_care");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the requested table name
$tableName = $_GET['table'];

$allowedTables = ['doctor', 'elder_info', 'caretaker_info', 'health_record', 'appointment','medication'];

if (!in_array($tableName, $allowedTables)) {
    echo "Invalid table name.";
    exit;
}

// Fetch column names dynamically, excluding 'password'
$sql = "SHOW COLUMNS FROM $tableName";
$columns = $conn->query($sql);

$columnNames = [];
while ($col = $columns->fetch_assoc()) {
    if ($col['Field'] !== 'password') {  // Exclude password column
        $columnNames[] = $col['Field'];
    }
}

// Fetch data dynamically
$sql = "SELECT " . implode(", ", $columnNames) . " FROM $tableName";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>" . ucfirst($tableName) . " List</h2>";
    echo "<table border='1'>
            <tr>";

    // Display column names
    foreach ($columnNames as $colName) {
        echo "<th>" . ucfirst($colName) . "</th>";
    }
    echo "</tr>";

    // Fetch data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($columnNames as $colName) {
            echo "<td>" . htmlspecialchars($row[$colName]) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>