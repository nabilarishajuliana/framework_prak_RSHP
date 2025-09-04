<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

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
        /* kiri - kanan */
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

</style>
<body>
     <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
            <img src="https://unair.ac.id/wp-content/uploads/2021/04/Logo-Universitas-Airlangga-UNAIR.png"
                style="height:50px;">
            <ul>
                <li><a href="/RSH/pageCover/Home.php">Home</a></li>
                <li><a href="/RSH/pageCover/StrukturOrgan.php">Struktur Organisasi</a></li>
                <li><a href="/RSH/pageCover/LayananUmum.php">Layanan Umum</a></li>
                <li><a href="/RSH/pageCover/VisiMisi.php">Visi Misi dan Tujuan</a></li>
            </ul>
        </div>
        <a href="login.php" class="login-button">Login</a>
    </div>
</body>
</html>