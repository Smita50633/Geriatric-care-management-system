<?php
$servername = "localhost";
$username = "root"; // Change as per your database setup
$password = "Smita@03";     // Change as per your database setup
$dbname = "geriatric_care"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!-- Health Records Table -->
<h2>My Health Records</h2>
<div class="health-tips">
    <?php
    $sql_health = "SELECT id, health_condition, medicine, doctor_name, record_date FROM health_records ORDER BY record_date DESC";
    $result_health = $conn->query($sql_health);

    if ($result_health->num_rows > 0) {
        echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; background: white; border-collapse: collapse;'>
                <tr style='background: #3949ab; color: white;'>
                    <th>ID</th>
                    <th>Health Condition</th>
                    <th>Medicine</th>
                    <th>Doctor</th>
                    <th>Date</th>
                </tr>";
        while ($row = $result_health->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['health_condition']}</td>
                    <td>{$row['medicine']}</td>
                    <td>{$row['doctor_name']}</td>
                    <td>{$row['record_date']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No health records found.</p>";
    }
    ?>
</div>

<!-- Appointments Table -->
<h2>Upcoming Appointments</h2>
<div class="health-tips">
    <?php
    $sql_appointment = "SELECT id, doctor_name, appointment_date, purpose, status FROM appointments ORDER BY appointment_date DESC";
    $result_appointment = $conn->query($sql_appointment);

    if ($result_appointment->num_rows > 0) {
        echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; background: white; border-collapse: collapse;'>
                <tr style='background: #3949ab; color: white;'>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Purpose</th>
                    <th>Status</th>
                </tr>";
        while ($row = $result_appointment->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['doctor_name']}</td>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['purpose']}</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No appointments found.</p>";
    }
    ?>
</div>

<!-- Payment Records Table -->
<h2>Payment Records</h2>
<div class="health-tips">
    <?php
    $sql_payment = "SELECT id, payment_date, amount, service, status FROM payments ORDER BY payment_date DESC";
    $result_payment = $conn->query($sql_payment);

    if ($result_payment->num_rows > 0) {
        echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; background: white; border-collapse: collapse;'>
                <tr style='background: #3949ab; color: white;'>
                    <th>ID</th>
                    <th>Payment Date</th>
                    <th>Amount (₹)</th>
                    <th>Service</th>
                    <th>Status</th>
                </tr>";
        while ($row = $result_payment->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['payment_date']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['service']}</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No payment records found.</p>";
    }
    ?>
</div>

<?php
$conn->close();
?>