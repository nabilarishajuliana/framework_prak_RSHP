<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Perawat') {
    header('Location: /RSH/pageCover/login.php');
    exit();
}


require_once '../../controller/RekamMedisController.php';
$ctrl = new RekamMedisController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newId = $ctrl->create($_POST);                // sekarang return ID
    if ($newId) {
        header('Location: updateRekamMedis.php?id=' . $newId);
        exit;
    }
}

$temu    = $ctrl->listTemuDokter();             // temu_dokter yang belum punya rekam (hari ini)
$dokters = $ctrl->listDokter();                 // user role=Dokter (aktif)
$kodeAll = $ctrl->listKode();                   // dropdown kode tindakan

$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Buat Rekam Medis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body>
    <?php include("../Navbar.php"); ?>

    <div class="container">
        <div class="header">
            <h1>Buat Rekam Medis</h1>
            <a class="btn secondary" href="readRekamMedis.php">Kembali</a>
        </div>

        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

        <form class="card" method="POST" action="" id="formRekam">
            <!-- HEADER -->
            <div class="form-row">
                <div class="field">
                    <label for="idreservasi">Temu Dokter (hari ini)</label>
                    <select class="input" id="idreservasi" name="idreservasi_dokter" required>
                        <option value="" disabled selected>- Pilih -</option>
                        <?php foreach ($temu as $t): ?>
                            <option value="<?= (int)$t['idreservasi_dokter'] ?>">
                                #<?= (int)$t['no_urut'] ?> — <?= htmlspecialchars($t['nama_pet']) ?> (<?= htmlspecialchars($t['nama_pemilik']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label for="dokter_pemeriksa">Dokter Pemeriksa</label>
                    <select class="input" id="dokter_pemeriksa" name="dokter_pemeriksa" required>
                        <option value="" disabled selected>— Pilih Dokter —</option>
                        <?php foreach ($dokters as $d): ?>
                            <option value="<?= (int)$d['idrole_user'] ?>">
                                <?= htmlspecialchars($d['nama']) ?> (<?= htmlspecialchars($d['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="field">
                    <label for="anamnesa">Anamnesa</label>
                    <input class="input" id="anamnesa" name="anamnesa" type="text" required>
                </div>
                <div class="field">
                    <label for="temuan_klinis">Temuan Klinis</label>
                    <textarea class="input" id="temuan_klinis" name="temuan_klinis" rows="3" placeholder="opsional"></textarea>
                </div>
                <div class="field">
                    <label for="diagnosa">Diagnosa</label>
                    <textarea class="input" id="diagnosa" name="diagnosa" rows="3" required></textarea>
                </div>
            </div>

            <!-- DETAIL (bisa lebih dari 1 baris) -->
            <div class="header" style="margin-top:8px;">
                <h2>Detail Tindakan / Terapi</h2>
            </div>
            <div class="card" style="padding:12px;">
                <div id="detailRows">
                    <div class="form-row detail-item">
                        <div class="field">
                            <label>Kode Tindakan</label>
                            <select class="input" name="idkode_tindakan_terapi[]">
                                <option value="">- Pilih -</option>
                                <?php foreach ($kodeAll as $k): ?>
                                    <option value="<?= (int)$k['idkode_tindakan_terapi'] ?>">
                                        <?= htmlspecialchars($k['kode']) ?> — <?= htmlspecialchars($k['deskripsi_tindakan_terapi']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="field" style="flex:1">
                            <label>Detail (catatan)</label>
                            <input class="input" name="detail[]" type="text" placeholder="cth: dosis, rute, frekuensi">
                        </div>
                        <div class="field" style="width:120px; align-self:end;">
                            <button type="button" class="btn danger" onclick="removeRow(this)">Hapus</button>
                        </div>
                    </div>
                </div>
                <div class="footer-actions" style="justify-content:flex-start; gap:8px;">
                    <button type="button" class="btn" onclick="addRow()">+ Tambah Baris</button>
                </div>
            </div>

            <div class="footer-actions">
                <a class="btn secondary" href="readRekamMedis.php">Batal</a>
                <button class="btn" type="submit">Simpan & Lanjut Kelola</button>
            </div>
        </form>
    </div>

    <script>
        function addRow() {
            const wrap = document.getElementById('detailRows');
            const node = wrap.querySelector('.detail-item').cloneNode(true);
            // reset nilai
            node.querySelector('select').selectedIndex = 0;
            node.querySelector('input[name="detail[]"]').value = '';
            wrap.appendChild(node);
        }

        function removeRow(btn) {
            const wrap = document.getElementById('detailRows');
            const rows = wrap.querySelectorAll('.detail-item');
            if (rows.length > 1) btn.closest('.detail-item').remove();
        }
    </script>

</body>

</html>