<?php
require_once '../../controller/PemilikController.php';
$controller = new PemilikController();

if (isset($_GET['id'])) {
    $idPemilik = (int)$_GET['id'];
    $controller->delete($idPemilik); // Panggil method delete dari controller
}

$pemilikList = $controller->index();

/* Flash message */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Data Pemilik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>
<body>

  <?php include("../Navbar.php"); ?>

  <div class="container">
    <div class="header">
      <h1>Data Pemilik</h1>
      <a class="btn" href="tambahPemilik.php">+ Tambah Pemilik</a>
    </div>

    <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th style="width:90px">ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th style="width:140px">No. WA</th>
            <th>Alamat</th>
            <th style="width:180px">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$pemilikList): ?>
          <tr><td colspan="6" class="small">Belum ada data.</td></tr>
        <?php else: foreach ($pemilikList as $p): ?>
          <tr>
            <td><?= (int)$p['idpemilik'] ?></td>
            <td><span class="badge"><?= htmlspecialchars($p['nama']) ?></span></td>
            <td><?= htmlspecialchars($p['email']) ?></td>
            <td><?= htmlspecialchars($p['no_wa']) ?></td>
            <td><?= htmlspecialchars($p['alamat']) ?></td>
            <td class="actions">
              <a class="btn secondary" href="updatePemilik.php?id=<?= (int)$p['idpemilik'] ?>">Edit</a>
              <a class="btn danger"
                 href="readPemilik.php?id=<?= (int)$p['idpemilik'] ?>"
                 onclick="return confirm('Apakah Anda yakin ingin menghapus pemilik ini?')">
                 Hapus
              </a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <p class="small">Total data: <?= count($pemilikList) ?></p>
  </div>

</body>
</html>