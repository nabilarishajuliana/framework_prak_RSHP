<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Dinamis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: #002366;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar ul li {
            margin-right: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-button {
            color: red;
            background-color: aliceblue;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
            <img src="https://unair.ac.id/wp-content/uploads/2021/04/Logo-Universitas-Airlangga-UNAIR.png"
                style="height:50px;">
        </div>
        <div class="navbar-center">
            <ul>
                <li><a href="/RSH/pagePemilik/pemilik.php">Home</a></li>
            </ul>
        </div>
        <div class="navbar-right">
            <!-- Logout button yang terhubung ke logout.php -->
            <a href="/RSH/pageCover/logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>

</html>