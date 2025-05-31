<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elder's Dashboard</title>
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
        
        .nav__container {
            padding: 2rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
          }
        .nav__logo span {
            color: var(--secondary-color);
          }
        

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 6px;
            padding: 0;
            margin-left: -10%;
        }
        .navbar ul li {
          margin-left:20px;
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

        .nav__logo {
          font-size: 1.8rem;
          font-weight: 700;
          color: var(--white);
        }
        

        /* Navbar styles */
        .navbar {
            display: flex;
            align-items: center;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .navbar ul li {
            display: inline-block;
            margin-left:-7%;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar ul li a:hover {
            background-color: #01624e;
        }

        /* Footer */
        footer {
            background: #0d846c;
            color: white;
            padding: 10px;
            text-align: center;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        /* Layout */
        .container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background: #e8eaf6;
            padding: 20px;
            color: white;
            box-shadow: h-offset v-offset blur spread color;
            overflow-y: auto;
            height:100vh;
            padding-top:9%;
        }

        .sidebar button {
            width: 80%;
            padding: 15px;
            margin-top: 20px;
            background: linear-gradient(135deg,#0d846c ,#0d846c);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar button:hover {
            background: linear-gradient(135deg,#fb923c,#fb923c);
            transform: translateY(-3px);
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            margin-top:5%;
        }

        h2 {
            margin: 20px 0 10px;
        }

        .exercise, .health-tips {
            background: #e8eaf6;
            padding: 15px;
            margin-top: 10px;
            border-radius: 8px;
        }

        button {
            display: inline-block;
            padding: 15px 25px;
            margin: 15px 0;
            background: linear-gradient(135deg,#0d846c, #0d846c);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #fb923c, #fb923c);
            transform: translateY(-3px);
        }

    
#tableContainer {
    margin:0%;
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}


/* Table styling */
#tableContainer h2 {
    text-align: center;
    color: #fb923c;
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

#tableContainer tr:nth-child(even) {
    background-color: #f9f9f9;
}

#tableContainer tr:hover {
    background-color: #f1f1f1;
}

  </style>
  <script>
function showTable(tableName) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("tableContainer").innerHTML = xhr.responseText;
      }
  };

  // Add the type as a query parameter
  xhr.open("POST", "get_details_EC.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("type=" + tableName); // Send type as POST data
}function showTable(tableName) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                document.getElementById("tableContainer").innerHTML = xhr.responseText;
            } else {
                console.error("Error: " + xhr.status);
            }
        }
    };

    xhr.open("POST", "get_details_EC.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("type=" + encodeURIComponent(tableName));
}

// Load health records by default when the page loads
//document.addEventListener("DOMContentLoaded", function () {
 //   showTable("health");
//});

</script>
</head>

<body>
  <header>
    <div class="main">
    <header class="header">
        <nav class="section__container nav__container">
            <div class="nav__logo">Geriatric<span>Care</span></div>
        
             
        </nav>

        <nav class="navbar">
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="elderprofile.php">My Profile</a></li>
            </ul>
        </nav>
    </header>
  <div class="container">
    <div class="sidebar">
      <!-- <button onclick="showTable('health')">Health Record</button> -->
      <button onclick="showTable('medication')">Medication details</button>
      <button onclick="location.href='games.html'">Mind Games</button>
      <button id="emergencyAlertBtn" onclick="location.href='send_sms1.php'">Emergency Alert</button>
      

      <!-- <button onclick="showTable('appointment')">Appointment</button> -->
      <button onclick="location.href='payment.php'">Payment</button>
    </div>

    <div class="main-content">
      <h2>Healthy Habits</h2>
      <div class="health-tips">
        <ul>
          <li>💧 Stay hydrated and drink plenty of water.</li>
          <li>🚶‍♂ Take a short walk daily to stay active.</li>
          <li>🥗 Eat balanced meals with fruits and vegetables.</li>
          <li>💤 Get enough sleep every night.</li>
          <li>🧘‍♂ Practice simple stretching or yoga for flexibility.</li>
          <li>📞 Connect with family and friends regularly to stay emotionally healthy.</li>
        </ul>
      </div>

      <!-- Table will be injected here dynamically -->
      <div id="tableContainer"></div>
    </div>
  </div>

  <footer>
  Copyright © 2025 Geriatric Management System. All rights reserved.  </footer>
</body>

</html>