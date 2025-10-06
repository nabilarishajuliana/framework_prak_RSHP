<?php
session_start();

// proteksi admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Resepsionis') {
    header('Location: /RSH/pageCover/login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include "Navbar.php"; ?>

    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Halo, <?= htmlspecialchars($_SESSION['nama']) ?> 👋</h1>
            <p class="hero-subtitle">
                Selamat datang di pusat kendali klinik. Kelola pengguna, data hewan, antrean temu dokter, dan tindakan medis dalam satu tempat.
            </p>
            <!-- <div class="hero-actions">
                <a class="btn" href="/rsh/pageAdmin/pagetemudokter/readTemuDokter.php">Lihat Antrean</a>
            </div> -->
        </div>

        <!-- ilustrasi (SVG, tanpa file gambar) -->
        <div class="hero-art" aria-hidden="true">

        </div>
    </section>
</body>

</html>