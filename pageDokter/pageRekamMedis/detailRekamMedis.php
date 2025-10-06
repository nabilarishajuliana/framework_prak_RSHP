<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Dokter') {
    header('Location: /RSH/pageCover/login.php');
    exit();
}

require_once '../../controller/RekamMedisController.php';
$ctrl = new RekamMedisController();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "ID tidak valid.";
    exit;
}

$data = $ctrl->get($id);
if (!$data) {
    echo "Rekam medis tidak ditemukan.";
    exit;
}

$details = $ctrl->details($id);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Rekam Medis — Dokter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/RSH/assets/admin.css">
</head>

<body>
    <?php include("../Navbar.php"); ?>

    <div class="container">
        <div class="header">
            <div>
                <h1>Detail Rekam Medis</h1>
                <p class="muted">
                    Pet: <b><?= htmlspecialchars($data['nama_pet']) ?></b>
                    — Pemilik: <?= htmlspecialchars($data['nama_pemilik'] ?? '-') ?>
                    — No. Urut: <b><?= (int)$data['no_urut'] ?></b>
                    — Dokter: <b><?= htmlspecialchars($data['nama_dokter'] ?? '-') ?></b>
                    — Daftar: <?= htmlspecialchars($data['waktu_daftar']) ?>
                </p>
            </div>
            <a class="btn secondary" href="readRekamMedis.php">Kembali</a>
        </div>

        <!-- Header Rekam (read-only) -->
        <div class="card">
            <div class="form-row">
                <div class="field">
                    <label>Anamnesa</label>
                    <div class="readbox"><?= nl2br(htmlspecialchars($data['anamnesa'])) ?></div>
                </div>
                <div class="field">
                    <label>Temuan Klinis</label>
                    <div class="readbox"><?= nl2br(htmlspecialchars($data['temuan_klinis'] ?? '')) ?></div>
                </div>
                <div class="field">
                    <label>Diagnosa</label>
                    <div class="readbox"><?= nl2br(htmlspecialchars($data['diagnosa'])) ?></div>
                </div>
            </div>
        </div>

        <!-- Detail Tindakan / Terapi (read-only) -->
        <div class="header" style="margin-top:8px;">
            <h2>Detail Tindakan / Terapi</h2>
        </div>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:90px">ID</th>
                        <th style="width:110px">Kode</th>
                        <th>Deskripsi</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$details): ?>
                        <tr>
                            <td colspan="4" class="small">Belum ada tindakan.</td>
                        </tr>
                        <?php else: foreach ($details as $d): ?>
                            <tr>
                                <td><?= (int)$d['iddetail_rekam_medis'] ?></td>
                                <td><b><?= htmlspecialchars($d['kode']) ?></b></td>
                                <td><?= htmlspecialchars($d['deskripsi_tindakan_terapi']) ?></td>
                                <td><?= htmlspecialchars($d['detail']) ?></td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>