<?php

// Menghubungkan Controller
require_once '../../controller/jenisHewanControl.php';

// Membuat objek dari controller
$controller = new JenisHewanController();

// Mendapatkan data jenis hewan dengan memanggil method read()
$jenisHewanList = $controller->index();

if (isset($_GET['id'])) {
    $idjenis_hewan = (int)$_GET['id'];
    $controller->delete($idjenis_hewan); // Panggil method delete dari controller
}

$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body>
    <?php
    include("../Navbar.php");
    ?>
    
<div class="container">
  <div class="header">
    <h1>Jenis Hewan</h1>
    <a class="btn" href="tambahJenisHewan.php">+ Tambah Jenis</a>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th style="width:90px">ID</th>
          <th>Nama Jenis Hewan</th>
          <th style="width:180px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$jenisHewanList): ?>
          <tr><td colspan="3" class="small">Belum ada data.</td></tr>
        <?php else: foreach ($jenisHewanList as $jenisHewan): ?>
          <tr>
            <td><?= (int)$jenisHewan['idjenis_hewan'] ?></td>
            <td><span class="badge"><?= htmlspecialchars($jenisHewan['nama_jenis_hewan']) ?></span></td>
            <td class="actions">
              <a class="btn secondary" href="updateJenisHewan.php?id=<?= (int)$jenisHewan['idjenis_hewan'] ?>">Edit</a>
              <a class="btn danger"
                 href="readJenisHewan.php?id=<?= (int)$jenisHewan['idjenis_hewan'] ?>"
                 onclick="return confirm('Apakah Anda yakin ingin menghapus jenis hewan ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <p class="small">Total data: <?= count($jenisHewanList) ?></p>
</div>
</body>

</html>