<?php
require_once '../../controller/KodeTindakanController.php';
$controller = new KodeTindakanTerapiController();
$id = (int)($_GET['id'] ?? 0);
$data = $controller->getById($id);
if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}
$kats = $controller->getKategoriOptions();
$kkats = $controller->getKategoriKlinisOptions();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->update($id);
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
    <title>Edit Kode Tindakan/Terapi</title>
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body><?php include("../Navbar.php"); ?>
    <div class="container">
        <div class="header">
            <h1>Edit Kode Tindakan/Terapi</h1><a class="btn secondary" href="readKodeTindakan.php">Kembali</a>
        </div>
        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <form class="card" method="POST" action="">
            <div class="form-row">
                <div class="field">
                    <label for="kode">Kode</label>
                    <input class="input" id="kode" name="kode" value="<?= htmlspecialchars($data['kode']) ?>" required>
                </div>
                <div class="field">
                    <label for="idkategori">Kategori</label>
                    <select class="input" id="idkategori" name="idkategori" required>
                        <?php foreach ($kats as $k): ?>
                            <option value="<?= $k['idkategori'] ?>" <?= $k['idkategori'] == $data['idkategori'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="idkategori_klinis">Kategori Klinis</label>
                    <select class="input" id="idkategori_klinis" name="idkategori_klinis" required>
                        <?php foreach ($kkats as $k): ?>
                            <option value="<?= $k['idkategori_klinis'] ?>" <?= $k['idkategori_klinis'] == $data['idkategori_klinis'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($k['nama_kategori_klinis']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="field" style="flex:1">
                    <label for="deskripsi">Deskripsi Tindakan/Terapi</label>
                    <textarea class="input" id="deskripsi" name="deskripsi" rows="5" required><?= htmlspecialchars($data['deskripsi_tindakan_terapi']) ?></textarea>
                </div>
            </div>

            <div class="footer-actions">
                <a class="btn secondary" href="readKodeTindakan.php">Batal</a>
                <button class="btn" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>

</html>