<?php
session_start();

require_once '../../controller/PetController.php';
require_once '../../controller/PemilikController.php';
require_once '../../controller/RasHewanControl.php';

$petCtrl     = new PetController();
$pemilikCtrl = new PemilikController();
$rasCtrl     = new RasHewanController();

/* dropdown */
$pemilikOptions = $pemilikCtrl->index();
$rasOptions     = $rasCtrl->index();

/* submit */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($petCtrl->create($_POST)) {
    header('Location: readPet.php');
    exit();
  }
}

/* flash */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tambah Pet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>
<body>

  <?php include("../Navbar.php"); ?>

  <div class="container">
    <div class="header">
      <h1>Tambah Pet</h1>
      <a class="btn secondary" href="readPet.php">Kembali</a>
    </div>

    <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

    <form class="card" method="POST" action="">
      <div class="form-row">
        <div class="field">
          <label for="nama">Nama</label>
          <input class="input" id="nama" name="nama" type="text" placeholder="cth: Bubub" required>
        </div>
        <div class="field">
          <label for="tanggal_lahir">Tanggal Lahir</label>
          <input class="input" id="tanggal_lahir" name="tanggal_lahir" type="date" required>
        </div>
      </div>

      <div class="form-row">
        <div class="field">
          <label for="warna_tanda">Warna Tanda</label>
          <input class="input" id="warna_tanda" name="warna_tanda" type="text" placeholder="cth: coklat" required>
        </div>
        <div class="field">
          <label for="jenis_kelamin">Jenis Kelamin</label>
          <select class="input" id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">- Pilih -</option>
            <option value="L">Jantan</option>
            <option value="P">Betina</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="field">
          <label for="idpemilik">Pemilik</label>
          <select class="input" id="idpemilik" name="idpemilik" required>
            <option value="">- Pilih Pemilik -</option>
            <?php foreach ($pemilikOptions as $pm): ?>
              <option value="<?= (int)$pm['idpemilik'] ?>">
                <?= htmlspecialchars($pm['nama']) ?> (<?= htmlspecialchars($pm['email']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="idras_hewan">Ras Hewan</label>
          <select class="input" id="idras_hewan" name="idras_hewan" required>
            <option value="">- Pilih Ras -</option>
            <?php foreach ($rasOptions as $ras): ?>
              <option value="<?= (int)$ras['idras_hewan'] ?>">
                <?= htmlspecialchars($ras['nama_ras']) ?>
                <?php if (isset($ras['nama_jenis'])) echo ' - ' . htmlspecialchars($ras['nama_jenis']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="footer-actions">
        <a class="btn secondary" href="readPet.php">Batal</a>
        <button class="btn" type="submit">Simpan</button>
      </div>
    </form>
  </div>

</body>
</html>
