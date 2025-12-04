<?php
session_start();

require_once '../../controller/PetController.php';
require_once '../../controller/PemilikController.php';
require_once '../../controller/RasHewanControl.php';

$petCtrl     = new PetController();
$pemilikCtrl = new PemilikController();
$rasCtrl     = new RasHewanController();

$id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pet = $petCtrl->get($id);
if (!$pet) {
    echo "Data pet tidak ditemukan.";
    exit;
}

/* dropdown */
$pemilikOptions = $pemilikCtrl->index();
$rasOptions     = $rasCtrl->index();

/* submit */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($petCtrl->update($id, $_POST)) {
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
    <title>Edit Pet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>

<body>

    <?php include("../Navbar.php"); ?>

    <div class="container">
        <div class="header">
            <h1>Edit Pet</h1>
            <a class="btn secondary" href="readPet.php">Kembali</a>
        </div>

        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

        <form class="card" method="POST" action="">
            <div class="form-row">
                <div class="field">
                    <label for="nama">Nama</label>
                    <input class="input" id="nama" name="nama" type="text"
                        value="<?= htmlspecialchars($pet['nama']) ?>" required>
                </div>
                <div class="field">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input class="input" id="tanggal_lahir" name="tanggal_lahir" type="date"
                        value="<?= htmlspecialchars($pet['tanggal_lahir']) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="field">
                    <label for="warna_tanda">Warna Tanda</label>
                    <input class="input" id="warna_tanda" name="warna_tanda" type="text"
                        value="<?= htmlspecialchars($pet['warna_tanda']) ?>" required>
                </div>
                <div class="field">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="input" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="L" <?= ($pet['jenis_kelamin'] === 'L') ? 'selected' : '' ?>>Jantan</option>
                        <option value="P" <?= ($pet['jenis_kelamin'] === 'P') ? 'selected' : '' ?>>Betina</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="field">
                    <label for="idpemilik">Pemilik</label>
                    <select class="input" id="idpemilik" name="idpemilik" required>
                        <?php foreach ($pemilikOptions as $pm): ?>
                            <option value="<?= (int)$pm['idpemilik'] ?>" <?= ((int)$pm['idpemilik'] === (int)$pet['idpemilik']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pm['nama']) ?> (<?= htmlspecialchars($pm['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label for="idras_hewan">Ras Hewan</label>
                    <select class="input" id="idras_hewan" name="idras_hewan" required>
                        <?php foreach ($rasOptions as $ras): ?>
                            <option value="<?= (int)$ras['idras_hewan'] ?>" <?= ((int)$ras['idras_hewan'] === (int)$pet['idras_hewan']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ras['nama_ras']) ?>
                                <?php if (isset($ras['nama_jenis'])) echo ' - ' . htmlspecialchars($ras['nama_jenis']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="footer-actions">
                <a class="btn secondary" href="readPet.php">Batal</a>
                <button class="btn" type="submit">Update</button>
            </div>
        </form>
    </div>

</body>

</html>