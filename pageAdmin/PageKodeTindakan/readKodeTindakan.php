<?php
require_once '../../controller/KodeTindakanController.php';
$controller = new KodeTindakanTerapiController();
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
    <title>Kode Tindakan/Terapi</title>
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body><?php include("../Navbar.php"); ?>
    <div class="container">
        <div class="header">
            <h1>Kode Tindakan/Terapi</h1><a class="btn" href="tambahKodeTindakan.php">+ Tambah</a>
        </div>
        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:70px">ID</th>
                        <th style="width:90px">Kode</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Kategori Klinis</th>
                        <th style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$list): ?><tr>
                            <td colspan="6" class="small">Belum ada data.</td>
                        </tr>
                        <?php else: foreach ($list as $r): ?>
                            <tr>
                                <td><?= (int)$r['idkode_tindakan_terapi'] ?></td>
                                <td><b><?= htmlspecialchars($r['kode']) ?></b></td>
                                <td><?= htmlspecialchars($r['deskripsi_tindakan_terapi']) ?></td>
                                <td><span class="badge"><?= htmlspecialchars($r['nama_kategori']) ?></span></td>
                                <td><span class="badge"><?= htmlspecialchars($r['nama_kategori_klinis']) ?></span></td>
                                <td class="actions">
                                    <a class="btn secondary" href="updateKodeTindakan.php?id=<?= $r['idkode_tindakan_terapi'] ?>">Edit</a>
                                    <a class="btn danger" href="readKodeTindakan.php?id=<?= $r['idkode_tindakan_terapi'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
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