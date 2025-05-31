<?php
include 'config.php'; // Database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Caretaker Dashboard</title>
  <style>
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
    .nav__logo {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--white);
    }
  
    .navbar ul {
      list-style: none;
      display: flex;
      padding: 0px;
    }
    .navbar ul li {
        margin-right:30px;
      margin-left:-7%;
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
    .container {
      display: flex;
      flex: 1;
      overflow: hidden;
      margin-top: 5%;
    }
    .sidebar {
      width: 250px;
      background: #e8eaf6;
      padding: 20px;
      height: 100vh;
    }
    .sidebar button {
      width: 80%;
      padding: 15px;
      margin-top: 20px;
      background: var(--primary-color-dark);
      color: white;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .sidebar button:hover {
      background: var(--secondary-color);
      transform: translateY(-3px);
    }
    .main-content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }
    #tableContainer {
      width: 90%;
      margin: auto;
    }
    #tableContainer table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    #tableContainer th, #tableContainer td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    #tableContainer th {
      background-color: #0d846c;
      color: white;
    }
    footer {
      background: #0d846c;
      color: white;
      padding: 10px;
      text-align: center;
    }
    .nav__logo span {
      color: #fb923c;
    }
  </style>
  <script>

function showTable(tableName) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                document.getElementById("tableContainer").innerHTML = xhr.responseText;
            } else {
                alert("Error loading data: " + xhr.status);
            }
        }
    };
    xhr.open("GET", "fetch_data.php?table=" + tableName, true);
    xhr.send();
}

function updateMedicalDetails(elderId) {
    window.location.href = "medication_update.php?elder_id=" + elderId;
}


function confirmAppointment(appointmentId) {
    if (confirm("Are you sure you want to book this slot?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "confirm_slot.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    if (xhr.responseText.trim() === "success") {
                        alert("Appointment booked successfully!");
                        showTable('appointment_slots');
                    } else {
                        alert("Error: " + xhr.responseText);
                    }
                } else {
                    alert("Server error: " + xhr.status);
                }
            }
        };
        xhr.send("appointment_id=" + appointmentId);
    }
}
</script>

</head>
<body>
  <header class="header">
    <div class="nav__logo">Geriatric<span>Care</span></div>
    <nav class="navbar">
      <ul>
        <li><a href="index.html">HOME</a></li>
        <li><a href="caretakerProfile.php">My Profile</a></li>
      </ul>
    </nav>
  </header>
 
  <div class="container">
    <div class="sidebar">
    <br><br><br>
    <button onclick="showTable('elder_info')">View Elders</button>
    <br><br><br>
    <button onclick="showTable('appointment_slots')">Book Appointment</button>
   
    </div>
    <div class="main-content">
      <h2>Welcome to Caretaker Dashboard</h2>
      <div id="tableContainer"></div>
    </div>
  </div>

  <footer>
  Copyright © 2025 Geriatric Management System. All rights reserved.  </footer>
</body>
</html>
