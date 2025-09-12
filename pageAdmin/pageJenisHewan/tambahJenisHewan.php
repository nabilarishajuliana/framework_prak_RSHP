<?php

// Menghubungkan Controller
require_once '../../controller/jenisHewanControl.php';

// Membuat objek dari controller
$controller = new JenisHewanController();

// Menjalankan proses create user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->create(); // Memanggil metode create() dari controller
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
    <h1>Tambah Jenis Hewan</h1>
    <a class="btn secondary" href="readJenisHewan.php">Kembali</a>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form class="card" method="POST" action="">
    <div class="form-row">
      <div class="field">
        <label for="nama_jenis">Nama Jenis Hewan</label>
        <input class="input" type="text" id="nama_jenis" name="nama_jenis" placeholder="cth: Kucing, Anjing, Burung" required>
      </div>
    </div>

    <div class="footer-actions">
      <a class="btn secondary" href="readJenisHewan.php">Batal</a>
      <button class="btn" type="submit">Simpan</button>
    </div>
  </form>
</div>
</body>

</html>