<?php
session_start();

// proteksi admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: loginView.php');
    exit();
}

// (opsional) statistik cepat
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';
$db = (new Database())->getConnection();

function quickCount(mysqli $db, string $sql): int
{
    $res = $db->query($sql);
    return $res ? (int)$res->fetch_assoc()['c'] : 0;
}
$stat_total_user   = quickCount($db, "SELECT COUNT(*) c FROM user");
$stat_total_pet    = quickCount($db, "SELECT COUNT(*) c FROM pet");
$stat_antrian_hari = quickCount($db, "SELECT COUNT(*) c FROM temu_dokter WHERE DATE(waktu_daftar)=CURDATE()");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/admin.css" />
</head>

<body>

    <?php include "Navbar.php"; ?>

    <div class="container">
        <!-- HERO -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Halo, <?= htmlspecialchars($_SESSION['nama']) ?> 👋</h1>
                <p class="hero-subtitle">
                    Selamat datang di pusat kendali klinik. Kelola pengguna, data hewan, antrean temu dokter, dan tindakan medis dalam satu tempat.
                </p>
                <div class="hero-actions">
                    <a class="btn" href="/rsh/pageAdmin/pagetemudokter/readTemuDokter.php">Lihat Antrean</a>
                </div>
            </div>

            <!-- ilustrasi (SVG, tanpa file gambar) -->
            <div class="hero-art" aria-hidden="true">

            </div>
        </section>

        <!-- QUICK STATS -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stat_total_user) ?></div>
                <div class="stat-label">Total User</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stat_total_pet) ?></div>
                <div class="stat-label">Total Pet</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stat_antrian_hari) ?></div>
                <div class="stat-label">Antrean Hari Ini</div>
            </div>
        </section>


    </div>

</body>

</html>