<?php
session_start();
if (!isset($_SESSION['logged_in']) || !isset($_SESSION['pemilik_id'])) {
    header('Location: /RSH/pageCover/login.php'); exit();
}

require_once '../../controller/RekamMedisController.php';
$ctrl = new RekamMedisController();

// Ambil idrekam dari GET
$idrekam = (int)($_GET['id'] ?? 0);
if ($idrekam <= 0) {
    echo "ID rekam medis tidak valid."; exit;
}

// Ambil header rekam medis
$data = $ctrl->get($idrekam);
if (!$data) {
    echo "Rekam medis tidak ditemukan."; exit;
}

// Pastikan pet termasuk milik pemilik
if ($data['idpemilik'] != $_SESSION['pemilik_id']) {
    echo "Anda tidak berhak melihat rekam medis ini."; exit;
}

// Ambil detail tindakan
$details = $ctrl->getDetailByRekam($idrekam);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Rekam Medis Pet</title>
<link rel="stylesheet" href="/RSH/assets/admin.css">
</head>
<body>
<?php include("../Navbar.php"); ?>

<div class="container">
  <div class="header">
    <h1>Detail Rekam Medis Pet: <?= htmlspecialchars($data['nama_pet']) ?></h1>
    <p class="muted">
        Pemilik: <?= htmlspecialchars($data['nama_pemilik'] ?? '-') ?> — 
        No. Urut: <b><?= (int)$data['no_urut'] ?></b> — 
        Dokter: <?= htmlspecialchars($data['nama_dokter'] ?? '-') ?>
    </p>
    <a class="btn" href="readRekamMedisPet.php?id=<?= $data['idpet'] ?>">Kembali</a>
  </div>

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

  <div class="header" style="margin-top:8px;">
    <h2>Detail Tindakan / Terapi</h2>
  </div>
  <div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!$details): ?>
                <tr><td colspan="4" class="small">Belum ada tindakan.</td></tr>
            <?php else: foreach ($details as $d): ?>
                <tr>
                    <td><?= (int)$d['iddetail_rekam_medis'] ?></td>
                    <td><b><?= htmlspecialchars($d['kode']) ?></b></td>
                    <td><?= htmlspecialchars($d['deskripsi_tindakan_terapi']) ?></td>
                    <td><?= htmlspecialchars($d['detail']) ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
  </div>
</div>
</body>
</html>
