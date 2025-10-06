<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Dokter') {
    header('Location: /RSH/pageCover/login.php');
    exit();
}

require_once '../../controller/RekamMedisController.php';
$ctrl  = new RekamMedisController();
$list  = $ctrl->index();

$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekam Medis — Dokter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/RSH/assets/admin.css">
</head>

<body>
    <?php include("../Navbar.php"); ?>

    <div class="container">
        <div class="header">
            <h1>Rekam Medis</h1>
            <div class="muted">Mode Dokter — lihat data rekam medis beserta detail.</div>
        </div>

        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:90px">ID</th>
                        <th style="width:110px">No. Urut</th>
                        <th>Waktu Daftar</th>
                        <th>Pet</th>
                        <th>Pemilik</th>
                        <th>Dokter</th>
                        <th>Diagnosa</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$list): ?>
                        <tr>
                            <td colspan="8" class="small">Belum ada rekam medis.</td>
                        </tr>
                        <?php else: foreach ($list as $r): ?>
                            <tr>
                                <td><?= (int)$r['idrekam_medis'] ?></td>
                                <td>#<?= (int)$r['no_urut'] ?></td>
                                <td><?= htmlspecialchars($r['waktu_daftar']) ?></td>
                                <td><span class="badge"><?= htmlspecialchars($r['nama_pet']) ?></span></td>
                                <td><?= htmlspecialchars($r['nama_pemilik'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($r['nama_dokter'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($r['diagnosa']) ?></td>
                                <td class="actions">
                                    <a class="btn secondary" href="detailRekamMedis.php?id=<?= (int)$r['idrekam_medis'] ?>">Lihat</a>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>

        <p class="small">Total data: <?= count($list) ?></p>
    </div>
</body>

</html>