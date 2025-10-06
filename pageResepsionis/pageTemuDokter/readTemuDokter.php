<?php
session_start();

require_once '../../controller/TemuDokterController.php';
$ctrl = new TemuDokterController();

/* aksi cepat: selesai / batal / hapus */
if (isset($_GET['act'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['act'] === 'done')   { $ctrl->setStatus($id, 'S'); }
    if ($_GET['act'] === 'cancel') { $ctrl->setStatus($id, 'B'); }
    if ($_GET['act'] === 'del')    { $ctrl->delete($id); }
    exit; // setStatus/delete seharusnya redirect; ini jaga-jaga
}

/* data antrian (hari ini) */
$list = $ctrl->index();

/* flash */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Antrian Temu Dokter (Hari Ini)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>
<body>

  <?php include("../Navbar.php"); ?>

  <div class="container">
    <div class="header">
      <div>
        <h1>Antrian Temu Dokter</h1>
        <p class="muted">Menampilkan pendaftaran <b>hari ini</b>.</p>
      </div>
      <a class="btn" href="tambahTemuDokter.php">+ Daftarkan Pet</a>
    </div>

    <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th style="width:90px">No. Urut</th>
            <th style="width:200px">Waktu Daftar</th>
            <th>Pet</th>
            <th>Pemilik</th>
            <th style="width:110px">Status</th>
            <th style="width:220px">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$list): ?>
          <tr><td colspan="7" class="small">Belum ada antrian hari ini.</td></tr>
        <?php else: $i=1; foreach ($list as $row): ?>
          <tr>
            <td><b><?= (int)$row['no_urut'] ?></b></td>
            <td><?= htmlspecialchars($row['waktu_daftar']) ?></td>
            <td><span class="badge"><?= htmlspecialchars($row['nama_pet']) ?></span></td>
            <td><?= htmlspecialchars($row['nama_pemilik']) ?></td>
            <td>
              <?php
                $st = $row['status'];
                $label = $st==='N' ? 'Baru' : ($st==='S' ? 'Selesai' : 'Batal');
              ?>
              <span class="badge"><?= $label ?></span>
            </td>
            <td class="actions">
              <a class="btn secondary" href="?act=done&id=<?= (int)$row['idreservasi_dokter'] ?>">Selesai</a>
              <a class="btn warning"  href="?act=cancel&id=<?= (int)$row['idreservasi_dokter'] ?>">Batal</a>
              <a class="btn danger"
                 href="?act=del&id=<?= (int)$row['idreservasi_dokter'] ?>"
                 onclick="return confirm('Hapus antrian ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <p class="small">Total antrian: <?= count($list) ?></p>
  </div>

</body>
</html>
