<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medication Details Form</title>
    <style>
        * {
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        html, body {
            width: 100%;
            height: 100vh;
            background-color: #f5f5f5;
        }
        
        /* Header styles */
        .header {
            display: flex;
            /* position: fixed; */
            margin-top:-10px;
            height: 12%;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            padding: 10px 8px;
            margin-left:-10px;
            background-color: #0077b6;
            color: white;
            z-index: 1;
        }

        .logo img {
            width: 80px;
            height: auto;
            border-radius: 50%;
        }

        .title h2 {
            margin-left: -60%;
            font-size: 24px;
            font-weight: bold;
        }
     
        /* Navbar styles */
        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            display: inline-block;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar ul li a:hover {
            background-color: #03045e;
        }

        /* Container */
        .container {
            background: #fff;
            padding: 20px;
            margin-top:10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Footer */
        footer {
            background: #0077b6;
            color: white;
            padding: 10px;
            text-align: center;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }
    </style>
</head>
<body>
    <header>
        <div class="header">
            <div class="logo">
                <img src="LOGO.jpg" alt="Logo">
            </div>
            <div class="title">
                <h2>Geriatric Care Management System</h2>
            </div>
            <nav class="navbar">
                <ul>
                    <li><a href="caretakerdashboard.php">BACK</a></li>
                   
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Medication Details Form</h2>
        <form action="medication_update.php" method="post">
            <label for="elder_id">Elder ID:</label>
            <input type="text" id="elder_id" name="elder_id" required>
            
            <label for="medication_name">Medication Name:</label>
            <input type="text" id="medication_name" name="medication_name" required>
            
            <label for="dosage">Dosage:</label>
            <input type="text" id="dosage" name="dosage" required>
            
            <label for="frequency">Frequency:</label>
            <input type="text" id="frequency" name="frequency" required>
            
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
            
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>