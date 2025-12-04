
<?php

require_once '../../controller/PemilikController.php';
$controller = new PemilikController();

/* submit */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($controller->create($_POST)) {
    header('Location: readPemilik.php');
    exit();
  }
}

/* flash message */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);

/* sticky form (kalau gagal validasi) */
$old = $_POST ?? [];
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tambah Pemilik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>
<body>

  <?php include("../Navbar.php"); ?>

  <div class="container">
    <div class="header">
      <h1>Tambah Pemilik</h1>
      <a class="btn secondary" href="readPemilik.php">Kembali</a>
    </div>

    <?php if ($msg): ?><div class="alert success"><?= h($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?= h($err) ?></div><?php endif; ?>

    <form class="card" method="POST" action="" onsubmit="this.querySelector('button[type=submit]').disabled=true;">
      <div class="form-row">
        <div class="field">
          <label for="nama">Nama</label>
          <input class="input" type="text" id="nama" name="nama" placeholder="cth: Budi Santoso"
                 value="<?= h($old['nama'] ?? '') ?>" required />
        </div>
        <div class="field">
          <label for="email">Email</label>
          <input class="input" type="email" id="email" name="email" placeholder="nama@email.com"
                 value="<?= h($old['email'] ?? '') ?>" required />
        </div>
      </div>

      <div class="form-row">
        <div class="field">
          <label for="password">Password</label>
          <input class="input" type="password" id="password" name="password" placeholder="Minimal 6 karakter" minlength="6" required />
        </div>
        <div class="field">
          <label for="no_wa">No. WA</label>
          <input class="input" type="text" id="no_wa" name="no_wa" placeholder="cth: 08123456789"
                 value="<?= h($old['no_wa'] ?? '') ?>" />
        </div>
      </div>

      <div class="form-row">
        <div class="field" style="flex:1">
          <label for="alamat">Alamat</label>
          <textarea class="input" id="alamat" name="alamat" rows="4" placeholder="Nama jalan, RT/RW, kelurahan, kecamatan"><?= h($old['alamat'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="footer-actions">
        <a class="btn secondary" href="readPemilik.php">Batal</a>
        <button class="btn" type="submit">Simpan</button>
      </div>
    </form>
  </div>

</body>
</html>
