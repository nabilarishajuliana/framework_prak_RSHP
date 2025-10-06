<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Perawat') {
    header('Location: /RSH/pageCover/login.php');
    exit();
}

require_once '../../controller/RekamMedisController.php';
$ctrl = new RekamMedisController();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "ID tidak valid.";
    exit;
}

$data = $ctrl->get($id);
if (!$data) {
    echo "Rekam medis tidak ditemukan.";
    exit;
}

/* aksi hapus detail via GET */
if (isset($_GET['detail_del'])) {
    $ctrl->deleteDetail((int)$_GET['detail_del']);
    header("Location: updateRekamMedis.php?id=" . $id);
    exit;
}

/* update header */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['form'] ?? '') === 'header') {
    if ($ctrl->update($id, $_POST)) {
        header("Location: updateRekamMedis.php?id=" . $id);
        exit;
    }
}

/* tambah detail */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['form'] ?? '') === 'detail-add') {
    if ($ctrl->addDetail($id, $_POST)) {
        header("Location: updateRekamMedis.php?id=" . $id);
        exit;
    }
}

/* data tampilan */
$details = $ctrl->details($id);
$dokters = $ctrl->listDokter();   // berisi idrole_user, nama, email
$kodeAll = $ctrl->listKode();

$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Rekam Medis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body>
    <?php include("../Navbar.php"); ?>

    <div class="container">
        <div class="header">
            <div>
                <h1>Kelola Rekam Medis</h1>
                <p class="muted">
                    Pet: <b><?= htmlspecialchars($data['nama_pet']) ?></b>
                    — Pemilik: <?= htmlspecialchars($data['nama_pemilik']) ?>
                    — No. Urut: <b><?= (int)$data['no_urut'] ?></b>
                    <?php if (!empty($data['nama_dokter'])): ?> — Dokter: <?= htmlspecialchars($data['nama_dokter']) ?><?php endif; ?>
                </p>
            </div>
            <a class="btn secondary" href="readRekamMedis.php">Kembali</a>
        </div>

        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

        <!-- FORM HEADER -->
        <form class="card" method="POST" action="">
            <input type="hidden" name="form" value="header">

            <div class="form-row">
                <div class="field">
                    <label for="dokter_pemeriksa">Dokter Pemeriksa</label>
                    <?php $selectedDokter = (int)($data['dokter_pemeriksa'] ?? 0); ?>
                    <select class="input" id="dokter_pemeriksa" name="dokter_pemeriksa" required>
                        <option value="" disabled <?= $selectedDokter ? '' : 'selected' ?>>— Pilih Dokter —</option>
                        <?php foreach ($dokters as $d): ?>
                            <option value="<?= (int)$d['idrole_user'] ?>" <?= ((int)$d['idrole_user'] === $selectedDokter) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($d['nama']) ?> (<?= htmlspecialchars($d['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label for="anamnesa">Anamnesa</label>
                    <input class="input" id="anamnesa" name="anamnesa" type="text"
                        value="<?= htmlspecialchars($data['anamnesa']) ?>" required>
                </div>

                <div class="field">
                    <label for="temuan_klinis">Temuan Klinis</label>
                    <textarea class="input" id="temuan_klinis" name="temuan_klinis" rows="3"><?= htmlspecialchars($data['temuan_klinis']) ?></textarea>
                </div>

                <div class="field">
                    <label for="diagnosa">Diagnosa</label>
                    <textarea class="input" id="diagnosa" name="diagnosa" rows="3" required><?= htmlspecialchars($data['diagnosa']) ?></textarea>
                </div>
            </div>

            <div class="footer-actions">
                <button class="btn" type="submit">Simpan Perubahan</button>
            </div>
        </form>

        <!-- TABEL DETAIL -->
        <div class="header" style="margin-top:8px;">
            <h2>Detail Tindakan / Terapi</h2>
        </div>
        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:90px">ID</th>
                        <th style="width:110px">Kode</th>
                        <th>Deskripsi</th>
                        <th>Detail</th>
                        <th style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$details): ?>
                        <tr>
                            <td colspan="5" class="small">Belum ada tindakan.</td>
                        </tr>
                        <?php else: foreach ($details as $d): ?>
                            <tr>
                                <td><?= (int)$d['iddetail_rekam_medis'] ?></td>
                                <td><b><?= htmlspecialchars($d['kode']) ?></b></td>
                                <td><?= htmlspecialchars($d['deskripsi_tindakan_terapi']) ?></td>
                                <td><?= htmlspecialchars($d['detail']) ?></td>
                                <td class="actions">
                                    <a class="btn danger"
                                        href="updateRekamMedis.php?id=<?= $id ?>&detail_del=<?= (int)$d['iddetail_rekam_medis'] ?>"
                                        onclick="return confirm('Hapus tindakan ini?')">Hapus</a>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>

        <!-- TAMBAH DETAIL -->
        <form class="card" method="POST" action="">
            <input type="hidden" name="form" value="detail-add">
            <div class="form-row">
                <div class="field">
                    <label for="idkode">Kode Tindakan</label>
                    <select class="input" id="idkode" name="idkode_tindakan_terapi" required>
                        <option value="" disabled selected>- Pilih -</option>
                        <?php foreach ($kodeAll as $k): ?>
                            <option value="<?= (int)$k['idkode_tindakan_terapi'] ?>">
                                <?= htmlspecialchars($k['kode']) ?> — <?= htmlspecialchars($k['deskripsi_tindakan_terapi']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field" style="flex:1">
                    <label for="detail">Detail (catatan)</label>
                    <input class="input" id="detail" name="detail" type="text" required placeholder="cth: dosis, rute, frekuensi">
                </div>
            </div>
            <div class="footer-actions">
                <button class="btn" type="submit">Tambah Tindakan</button>
            </div>
        </form>
    </div>
</body>

</html>