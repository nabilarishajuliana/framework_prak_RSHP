<?php
require_once 'C:/xampp/htdocs/RSH/controller/RasHewanControl.php';
$controller = new RasHewanController();

/* hapus di sini biar tetap di halaman list */
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $controller->delete((int)$_GET['id']);
}

/* ambil data tabel */
$rows = $controller->index();

/* flash message */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Ras Hewan</title>
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>
<body>
   <?php
    include("../Navbar.php");
    ?>
<div class="container">
    
  <div class="header">
    <h1>Ras Hewan</h1>
    <a class="btn" href="tambahRasHewan.php">+ Tambah Ras</a>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th style="width:80px">ID</th>
          <th>Nama Ras</th>
          <th>Jenis Hewan</th>
          <th style="width:180px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="4" class="small">Belum ada data.</td></tr>
        <?php else: foreach ($rows as $r): ?>
          <tr>
            <td><?= (int)$r['idras_hewan'] ?></td>
            <td><span class="badge"><?= htmlspecialchars($r['nama_ras']) ?></span></td>
            <td><?= htmlspecialchars($r['nama_jenis_hewan']) ?></td>
            <td class="actions">
              <a class="btn secondary" href="updateRasHewan.php?id=<?= (int)$r['idras_hewan'] ?>">Edit</a>
              <a class="btn danger" href="?action=delete&id=<?= (int)$r['idras_hewan'] ?>"
                 onclick="return confirm('Yakin menghapus ras ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <p class="small">Total data: <?= count($rows) ?></p>
</div>
  </tbody>
</table>

</body>
</html>
