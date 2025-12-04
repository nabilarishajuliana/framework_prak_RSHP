<?php
require_once 'C:/xampp/htdocs/RSH/controller/RasHewanControl.php';
$controller = new RasHewanController();

/* Router tipis: submit update */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $controller->update((int)$_GET['id']);
}

/* Ambil data lama untuk prefilling */
if (!isset($_GET['id'])) {
    header("Location: readRasHewan.php"); exit();
}
$id    = (int) $_GET['id'];
$data  = $controller->getById($id);
$jenis = $controller->listJenis();

if (!$data) {
    session_start();
    $_SESSION['error'] = "Data tidak ditemukan.";
    header("Location: readRasHewan.php"); exit();
}

$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Ras Hewan</title>
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>
<body>
    <?php
    include("../Navbar.php");
    ?>
<div class="container">
  <div class="header">
    <h1>Edit Ras Hewan</h1>
    <a class="btn secondary" href="readRasHewan.php">Kembali</a>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form class="card" method="post" action="?id=<?= $id ?>">
    <div class="form-row">
      <div class="field">
        <label>Nama Ras</label>
        <input class="input" type="text" name="nama_ras"
               value="<?= htmlspecialchars($data['nama_ras']) ?>" required>
      </div>
      <div class="field">
        <label>Jenis Hewan</label>
        <select name="idjenis_hewan" required>
          <?php foreach ($jenis as $j): ?>
            <option value="<?= (int)$j['idjenis_hewan'] ?>"
              <?= ($j['idjenis_hewan']==$data['idjenis_hewan'])?'selected':'' ?>>
              <?= htmlspecialchars($j['nama_jenis_hewan']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="footer-actions">
      <a class="btn secondary" href="readRasHewan.php">Batal</a>
      <button class="btn" type="submit">Simpan Perubahan</button>
    </div>
  </form>
</div>
</body>
</html>
