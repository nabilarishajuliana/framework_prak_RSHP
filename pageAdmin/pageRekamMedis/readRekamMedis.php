<?php
session_start();
require_once '../../controller/RekamMedisController.php';
$ctrl = new RekamMedisController();

if (isset($_GET['del'])) {
    $ctrl->delete((int)$_GET['del']);
    exit;
}

$list = $ctrl->index();
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekam Medis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body>
    <?php include("../Navbar.php"); ?>

    <div class="container">
        <div class="header">
            <h1>Rekam Medis</h1>
            <a class="btn" href="tambahRekamMedis.php">+ Buat Rekam Medis</a>
        </div>

        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:80px">ID</th>
                        <th style="width:90px">No. Urut</th>
                        <th style="width:200px">Waktu Daftar</th>
                        <th>Pet</th>
                        <th>Pemilik</th>
                        <th>Diagnosa</th>
                        <th style="width:220px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$list): ?><tr>
                            <td colspan="7" class="small">Belum ada data.</td>
                        </tr>
                        <?php else: foreach ($list as $r): ?>
                            <tr>
                                <td><?= (int)$r['idrekam_medis'] ?></td>
                                <td><b><?= (int)$r['no_urut'] ?></b></td>
                                <td><?= htmlspecialchars($r['waktu_daftar']) ?></td>
                                <td><span class="badge"><?= htmlspecialchars($r['nama_pet']) ?></span></td>
                                <td><?= htmlspecialchars($r['nama_pemilik']) ?></td>
                                <td><?= htmlspecialchars($r['diagnosa']) ?></td>
                                <td class="actions">
                                    <a class="btn secondary" href="updateRekamMedis.php?id=<?= (int)$r['idrekam_medis'] ?>">Kelola</a>
                                    <a class="btn danger"
                                        href="readRekamMedis.php?del=<?= (int)$r['idrekam_medis'] ?>"
                                        onclick="return confirm('Hapus rekam medis ini beserta detailnya?')">Hapus</a>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
        <p class="small">Total: <?= count($list) ?></p>
    </div>
</body>

</html>