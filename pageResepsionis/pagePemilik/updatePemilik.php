<?php
session_start();

require_once '../../controller/PemilikController.php';
$controller = new PemilikController();

$id = (int)($_GET['id'] ?? 0);
$pemilik = $controller->get($id);
if (!$pemilik) { echo "Data pemilik tidak ditemukan."; exit; }

/* submit */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($controller->update($id, $_POST)) {
    header('Location: readPemilik.php');
    exit();
  }
}

/* flash */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);

/* sticky (pakai POST kalau ada, fallback ke data lama) */
$old = $_POST ?: $pemilik;
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Edit Pemilik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>
<body>

  <?php include("../Navbar.php"); ?>

  <div class="container">
    <div class="header">
      <h1>Edit Pemilik</h1>
      <a class="btn secondary" href="readPemilik.php">Kembali</a>
    </div>

    <?php if ($msg): ?><div class="alert success"><?= h($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?= h($err) ?></div><?php endif; ?>

    <form class="card" method="POST" action="" onsubmit="this.querySelector('button[type=submit]').disabled=true;">
      <div class="form-row">
        <div class="field">
          <label for="nama">Nama</label>
          <input class="input" type="text" id="nama" name="nama" value="<?= h($old['nama'] ?? '') ?>" required />
        </div>
        <div class="field">
          <label for="email">Email</label>
          <input class="input" type="email" id="email" name="email" value="<?= h($old['email'] ?? '') ?>" required />
        </div>
      </div>

      <div class="form-row">
        <div class="field">
          <label for="no_wa">No. WA</label>
          <input class="input" type="text" id="no_wa" name="no_wa" value="<?= h($old['no_wa'] ?? '') ?>" />
        </div>
        <div class="field">
          <label for="alamat">Alamat</label>
          <textarea class="input" id="alamat" name="alamat" rows="4"><?= h($old['alamat'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="footer-actions">
        <a class="btn secondary" href="readPemilik.php">Batal</a>
        <button class="btn" type="submit">Update</button>
      </div>
    </form>
  </div>

</body>
</html>
