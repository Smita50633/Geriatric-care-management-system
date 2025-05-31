<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page | Geriatric Care</title>
    <link rel="stylesheet" href="adminstyle.css">
    <style>
        :root {
            --primary-color: #12ac8e;
            --primary-color-dark: #0d846c;
            --primary-color-light: #e9f7f7;
            --secondary-color: #fb923c;
            --text-dark: #333333;
            --white: #ffffff;
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
            height:9%;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: var(--primary-color);
            color: white;
            z-index: 1000;
        }

        .logo img {
            height: 50px;
        }

        .title h2 {
            margin: 0;
            font-size: 24px;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 15px;
            padding: 0;
            margin: 0;
        }

        .navbar ul li {
            display: inline;
            margin-left:-1.2%;
        }

        .navbar ul li a, .navbar ul li button {
            background-color: var(--primary-color-dark);
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
          
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .navbar ul li a:hover, .navbar ul li button:hover {
            background-color: var(--secondary-color);
        }

        .main-container {
            padding: 100px 20px 50px;
            text-align: center;
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
.nav__logo {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--white);
}

        .table {
            max-width: 90%;
            margin: auto;
            padding: 25px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }

        .table table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--white);
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }
        .table h2{
            color:var( --secondary-color)
        }

        .footer {
            text-align: center;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            position: fixed;
            bottom: 0;
            margin-left:-2%;
            width: 100%;
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
            xhr.open("GET", "fetch_details.php?table=" + tableName, true);
            xhr.send();
        }
    </script>
</head>
<body>
    <header class="header">
    <nav class="section__container nav__container">
            <div class="nav__logo">Geriatric<span>Care</span></div>
        </nav>
        <nav class="navbar">
            <ul>
                <li><button onclick="location.href='index.html'">HOME</button></li>
                <li><button onclick="showTable('elder_info')">Elders</button></li>
                <li><button onclick="showTable('caretaker_info')">Caretakers</button></li>
                <li><button onclick="showTable('doctor')">Doctors</button></li>
                <li><button onclick="location.href='delete_elder.php'">Delete</button></li>
            </ul>
        </nav>
    </header>
    <br><br>
    <div class="main-container">
        <div id="tableContainer" class="table">
            <h2>Select a category to view details</h2>
           
    </div>
    <div class="footer">
    Copyright © 2025 Geriatric Management System. All rights reserved.    </div>
</body>
</html>
