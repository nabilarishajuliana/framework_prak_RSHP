<?php
require_once 'C:/xampp/htdocs/RSH/controller/RasHewanControl.php';
$controller = new RasHewanController();

/* kalau submit, langsung pakai controller->create()
   controller akan set session message & redirect ke readRasHewan.php */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->create();
}

/* untuk dropdown jenis */
$jenis = $controller->listJenis();

/* flash bila ada (misal dari validasi) */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Ras Hewan</title>
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>
<body>
    <?php
    include("../Navbar.php");
    ?>
<div class="container">
  <div class="header">
    <h1>Tambah Ras Hewan</h1>
    <a class="btn secondary" href="readRasHewan.php">Kembali</a>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form class="card" method="post" action="">
    <div class="form-row">
      <div class="field">
        <label>Nama Ras</label>
        <input class="input" type="text" name="nama_ras" placeholder="cth: Anggora" required>
      </div>
      <div class="field">
        <label>Jenis Hewan</label>
        <select name="idjenis_hewan" required>
          <option value="">-- Pilih Jenis --</option>
          <?php foreach ($jenis as $j): ?>
            <option value="<?= (int)$j['idjenis_hewan'] ?>">
              <?= htmlspecialchars($j['nama_jenis_hewan']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="footer-actions">
      <a class="btn secondary" href="readRasHewan.php">Batal</a>
      <button class="btn" type="submit">Simpan</button>
    </div>
  </form>
</div>
</body>
</html>
