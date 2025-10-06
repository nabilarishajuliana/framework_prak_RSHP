<?php
session_start();

require_once '../../controller/TemuDokterController.php';
$ctrl = new TemuDokterController();

/* submit pendaftaran */
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if ($ctrl->create($_POST)) {
        header('Location: readTemuDokter.php');
        exit();
    }
}

/* opsi dropdown pet (dengan nama pemilik) */
$pets = $ctrl->listPets();

/* flash */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Daftarkan Temu Dokter</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>
<body>

  <?php include("../Navbar.php"); ?>

  <div class="container">
    <div class="header">
      <h1>Daftarkan Temu Dokter</h1>
      <a class="btn secondary" href="readTemuDokter.php">Kembali</a>
    </div>

    <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

    <form class="card" method="POST" action="">
      <div class="form-row">
        <div class="field" style="flex:1">
          <label for="idpet">Pilih Pet</label>
          <select class="input" id="idpet" name="idpet" required>
            <option value="">- Pilih Pet -</option>
            <?php foreach ($pets as $p): ?>
              <option value="<?= (int)$p['idpet'] ?>">
                <?= htmlspecialchars($p['nama_pet']) ?> — pemilik: <?= htmlspecialchars($p['nama_pemilik']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p class="small" style="margin-top:6px;color:#6b7280">
            No. urut akan dihasilkan otomatis berdasarkan antrian hari ini.
          </p>
        </div>
      </div>

      <div class="footer-actions">
        <a class="btn secondary" href="readTemuDokter.php">Batal</a>
        <button class="btn" type="submit">Daftar</button>
      </div>
    </form>
  </div>

</body>
</html>
