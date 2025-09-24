<?php
require_once '../../controller/KategoriKlinisController.php';
$controller = new KategoriKlinisController();
if (isset($_GET['id'])) {
    $controller->delete((int)$_GET['id']);
}
$list = $controller->index();

$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Klinis</title>
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body><?php include("../Navbar.php"); ?>
    <div class="container">
        <div class="header">
            <h1>Kategori Klinis</h1><a class="btn" href="tambahKategoriKlinis.php">+ Tambah</a>
        </div>
        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:90px">ID</th>
                        <th>Nama Kategori Klinis</th>
                        <th style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$list): ?><tr>
                            <td colspan="3" class="small">Belum ada data.</td>
                        </tr>
                        <?php else: foreach ($list as $r): ?>
                            <tr>
                                <td><?= (int)$r['idkategori_klinis'] ?></td>
                                <td><span class="badge"><?= htmlspecialchars($r['nama_kategori_klinis']) ?></span></td>
                                <td class="actions">
                                    <a class="btn secondary" href="updateKategoriKlinis.php?id=<?= $r['idkategori_klinis'] ?>">Edit</a>
                                    <a class="btn danger" href="readKategoriKlinis.php?id=<?= $r['idkategori_klinis'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
        <p class="small">Total data: <?= count($list) ?></p>
    </div>
</body>

</html>