<?php
session_start();
if (!isset($_SESSION['logged_in']) || !isset($_SESSION['pemilik_id'])) {
    header('Location: /RSH/pageCover/login.php'); exit();
}

require_once '../../controller/RekamMedisController.php';
$ctrl = new RekamMedisController();

// Ambil id pet dari GET
$idpet = (int)($_GET['id'] ?? 0);
if ($idpet <= 0) { echo "Pet tidak valid."; exit; }

$list = $ctrl->getByPet($idpet);

$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Rekam Medis Pet</title>
<link rel="stylesheet" href="/RSH/assets/admin.css">
</head>
<body>
<?php include("../Navbar.php"); ?>

<div class="container">
    <div class="header">
        <h1>Rekam Medis Pet #<?= $idpet ?></h1>
        <a class="btn" href="../pemilik.php">Kembali ke Daftar Pet</a>
    </div>

    <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No Urut</th>
                    <th>Waktu Daftar</th>
                    <th>Pet</th>
                    <th>Pemilik</th>
                    <th>Dokter</th>
                    <th>Diagnosa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$list): ?>
                    <tr><td colspan="8">Belum ada rekam medis untuk pet ini.</td></tr>
                <?php else: foreach ($list as $r): ?>
                    <tr>
                        <td><?= (int)$r['idrekam_medis'] ?></td>
                        <td>#<?= (int)$r['no_urut'] ?></td>
                        <td><?= htmlspecialchars($r['waktu_daftar']) ?></td>
                        <td><?= htmlspecialchars($r['nama_pet']) ?></td>
                        <td><?= htmlspecialchars($r['nama_pemilik'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($r['nama_dokter'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($r['diagnosa']) ?></td>
                        <td>
                            <a class="btn secondary" href="detailRekamMedisPet.php?id=<?= (int)$r['idrekam_medis'] ?>">Lihat</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
