<?php
session_start();
if (!isset($_SESSION['logged_in']) || !isset($_SESSION['pemilik_id'])) {
    header('Location: /RSH/pageCover/login.php'); exit();
}

require_once '../controller/TemuDokterController.php';
$ctrl = new TemuDokterController();

// Ambil idpet dari GET
$idpet = (int)($_GET['id'] ?? 0);
if ($idpet <= 0) {
    echo "Pet tidak valid."; exit;
}

// Pastikan pet termasuk milik pemilik yang login
require_once '../controller/PemilikController.php';
$pemCtrl = new PemilikController();
$pets = $pemCtrl->getPetsByPemilikId($_SESSION['pemilik_id']);
$validPetIds = array_column($pets, 'idpet');
if (!in_array($idpet, $validPetIds)) {
    echo "Pet ini bukan milik Anda."; exit;
}

$queues = $ctrl->getQueuesByPet($idpet);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Temu Dokter Pet</title>
<link rel="stylesheet" href="/RSH/assets/admin.css">
</head>
<body>
<?php include("Navbar.php"); ?>

<div class="container">
  <div class="header">
    <h1>Temu Dokter untuk Pet <?= htmlspecialchars($idpet) ?></h1>
    <a class="btn" href="pemilik.php">Kembali ke Daftar Pet</a>
  </div>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>No Urut</th>
          <th>Waktu Daftar</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$queues): ?>
          <tr><td colspan="3">Belum ada temu dokter untuk pet ini.</td></tr>
        <?php else: foreach ($queues as $q): ?>
          <tr>
            <td><?= (int)$q['no_urut'] ?></td>
            <td><?= htmlspecialchars($q['waktu_daftar']) ?></td>
            <td><?= $q['status']==='N'?'Baru':($q['status']==='S'?'Selesai':'Batal') ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
