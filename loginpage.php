<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Geriatric Care</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
        :root {
            --primary-color: #12ac8e;
            --primary-color-dark: #0d846c;
            --primary-color-light: #e9f7f7;
            --secondary-color: #fb923c;
            --text-dark: #333333;
            --text-light: #767268;
            --white: #ffffff;
        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: var(--primary-color-light);
            margin: 0;
            padding: 0;
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

        .nav__logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
        }

        .nav__logo span {
            color: var(--secondary-color);
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 2px;
            padding: 0;
            margin: 0;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar ul li a:hover {
            background-color: var(--primary-color-dark);
        }


        .auth-container {
            max-width: 400px;
            margin: 10% auto;
            padding: 30px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        select{
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .btn {
            width: 50%;
            padding: 12px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: var(--primary-color-dark);
        }
    </style>
</head>

<body>
<header class="header">
        <nav class="section__container nav__container">
            <div class="nav__logo">Geriatric<span>Care</span></div>
        </nav>
        <nav class="navbar">
            <ul>
                <li><a href="index.html">HOME</a></li>
            </ul>
        </nav>
    </header>
    <div class="auth-container">
        <h2>Login</h2>

        <!-- Display error message if login fails -->
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="error-message">
                <?= $_SESSION['login_error'] ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form id="loginForm" action="loginCheck.php" method="post">
            <select id="role" name="role" required>
                <option value="">--Select Role--</option>
                <option value="admin" <?= isset($_SESSION['role_temp']) && $_SESSION['role_temp'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="elder" <?= isset($_SESSION['role_temp']) && $_SESSION['role_temp'] == 'elder_info' ? 'selected' : '' ?>>Elder</option>
                <option value="caretaker" <?= isset($_SESSION['role_temp']) && $_SESSION['role_temp'] == 'caretaker_info' ? 'selected' : '' ?>>Caretaker</option>
            </select>

            <input type="text" id="username" name="username" value="<?= $_SESSION['username_temp'] ?? '' ?>" required placeholder="Enter your username">
            
            <input type="password" id="password" name="password" minlength="6" required placeholder="Enter your password">
            
            <button type="submit" class="btn">Login</button>

            <h4>Don't have an account? <a href="register.html">Register</a></h4>
        </form>
    </div>

</body>
</html>
