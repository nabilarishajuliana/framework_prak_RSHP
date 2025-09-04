<?php



session_start();

// Cek apakah pengguna sudah login dan memiliki role Administrator
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
    header('Location: loginView.php'); // Jika tidak, arahkan ke halaman login
    exit();
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        /* Navbar */
        .navbar {
            background-color: #3da6c8;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar img {
            height: 40px;
        }

        .navbar-right {
            display: flex;
            gap: 20px;
        }

        .navbar-right a {
            color: black;
            text-decoration: none;
            font-weight: bold;
        }

        /* Container untuk card menu */
        .menu-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        /* Card link */
        .menu-card {
            width: 200px;
            height: 120px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
            text-decoration: none;
            color: #333;
        }

        .menu-card:hover {
            background: #3da6c8;
            color: white;
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <?php
    include "Navbar.php";
    ?>

    <!-- Menu Card -->
    <div class="menu-container">
        <a href="readUser.php" class="menu-card">Data User</a>
        <a href="manajemenRole.php" class="menu-card">Manajemen Role</a>
    </div>

</body>

</html>