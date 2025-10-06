<?php
session_start();

// Pastikan login sebagai pemilik
if (!isset($_SESSION['logged_in']) ||  $_SESSION['role'] !== "pemilik") {
    header('Location: /RSH/pageCover/login.php'); exit();
}

require_once '../controller/PemilikController.php';
$ctrl = new PemilikController();

$pemilikId = $_SESSION['pemilik_id'];  // Ambil pemilik_id dari session
$pets = $ctrl->getPetsByPemilikId($pemilikId);  // Ambil data pets berdasarkan pemilik ID

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Pet</title>
  <link rel="stylesheet" href="/RSH/assets/admin.css">
</head>
<body>
<?php include("Navbar.php"); ?>

<div class="container">

  <div class="header">
    <h1>Daftar Pet Anda  </h1>
    <a class="btn" href="addPet.php">Tambah Pet</a>
  </div>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>ID Pet</th>
          <th>Nama Pet</th>
          <th>Tanggal Lahir</th>
          <th>Warna Tanda</th>
          <th>Jenis Kelamin</th>
          <th>Rekam Medis</th>
          <th>Temu Dokter</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$pets): ?>
          <tr><td colspan="7" class="small">Anda belum memiliki pet.</td></tr>
        <?php else: foreach ($pets as $pet): ?>
          <tr>
            <td><?= $pet['idpet'] ?></td>
            <td><?= htmlspecialchars($pet['nama']) ?></td>
            <td><?= $pet['tanggal_lahir'] ?></td>
            <td><?= htmlspecialchars($pet['warna_tanda']) ?></td>
            <td><?= $pet['jenis_kelamin'] ?></td>
            <td>
              <a href="RekamMedisPet/readrekamMedisPet.php?id=<?= $pet['idpet'] ?>">Lihat Rekam Medis</a>
            </td>
            <td>
              <a href="temuDokterPet.php?id=<?= $pet['idpet'] ?>">Lihat Temu Dokter</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
