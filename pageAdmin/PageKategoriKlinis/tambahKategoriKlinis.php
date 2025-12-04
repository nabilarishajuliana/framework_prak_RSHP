<?php
require_once '../../controller/KategoriKlinisController.php';
$c = new KategoriKlinisController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c->create();
}
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori Klinis</title>
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body><?php include("../Navbar.php"); ?>
    <div class="container">
        <div class="header">
            <h1>Tambah Kategori Klinis</h1><a class="btn secondary" href="readKategoriKlinis.php">Kembali</a>
        </div>
        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <form class="card" method="POST" action="">
            <div class="form-row">
                <div class="field">
                    <label for="nama_kategori_klinis">Nama Kategori Klinis</label>
                    <input class="input" id="nama_kategori_klinis" name="nama_kategori_klinis" required>
                </div>
            </div>
            <div class="footer-actions">
                <a class="btn secondary" href="readKategoriKlinis.php">Batal</a>
                <button class="btn" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>