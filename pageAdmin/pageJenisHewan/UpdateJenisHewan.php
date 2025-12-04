<?php

// Menghubungkan Controller
require_once '../../controller/jenisHewanControl.php';

// Membuat objek dari controller
$controller = new JenisHewanController();

// Ambil ID dari query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$jenisHewan = $controller->getById($id);

if (!$jenisHewan) {
    echo "Jenis Hewan tidak ditemukan.";
    exit;
}

// Proses Update jika ada request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Panggil metode update dari controller
    $controller->update($id);
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
<?php include("../Navbar.php"); ?>

<div class="container">
  <div class="header">
    <h1>Edit Jenis Hewan</h1>
    <a class="btn secondary" href="readJenisHewan.php">Kembali</a>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form class="card" method="POST" action="">
    <div class="form-row">
      <div class="field">
        <label for="nama_jenis">Nama Jenis Hewan</label>
        <input class="input" type="text" id="nama_jenis" name="nama_jenis"
               value="<?= htmlspecialchars($jenisHewan['nama_jenis_hewan']) ?>" required>
      </div>
    </div>

    <div class="footer-actions">
      <a class="btn secondary" href="readJenisHewan.php">Batal</a>
      <button class="btn" type="submit">Simpan Perubahan</button>
    </div>
  </form>
</div>
</body>

</html>