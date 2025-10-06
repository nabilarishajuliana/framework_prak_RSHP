<?php
session_start();

require_once '../../controller/PetController.php';
$controller = new PetController();

/* Hapus bila ada request delete (controller idealnya redirect+exit) */
if (isset($_GET['id'])) {
    $idpet = (int)$_GET['id'];
    $controller->delete($idpet);
    exit; // jaga-jaga kalau controller tidak exit
}

/* Ambil data */
$petList = $controller->index();

/* Flash */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Data Pet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/rsh/assets/admin.css" />
</head>

<body>

    <?php include("../Navbar.php"); ?>

    <div class="container">
        <div class="header">
            <h1>Data Pet</h1>
            <a class="btn" href="tambahPet.php">+ Tambah Pet</a>
        </div>

        <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

        <div class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:70px">ID</th>
                        <th>Nama</th>
                        <th style="width:130px">Tanggal Lahir</th>
                        <th>Warna Tanda</th>
                        <th style="width:110px">Kelamin</th>
                        <th>Pemilik</th>
                        <th>Ras</th>
                        <th style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$petList): ?>
                        <tr>
                            <td colspan="8" class="small">Belum ada data.</td>
                        </tr>
                        <?php else: foreach ($petList as $p): ?>
                            <tr>
                                <td><?= (int)$p['idpet'] ?></td>
                                <td><span class="badge"><?= htmlspecialchars($p['nama']) ?></span></td>
                                <td><?= htmlspecialchars($p['tanggal_lahir']) ?></td>
                                <td><?= htmlspecialchars($p['warna_tanda']) ?></td>
                                <td>
                                    <?php
                                    $jk = strtoupper((string)$p['jenis_kelamin']);
                                    echo $jk === 'L' ? 'Jantan' : ($jk === 'P' ? 'Betina' : '-');
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($p['nama_pemilik']) ?></td>
                                <td><?= htmlspecialchars($p['nama_ras']) ?></td>
                                <td class="actions">
                                    <a class="btn secondary" href="updatePet.php?id=<?= (int)$p['idpet'] ?>">Edit</a>
                                    <a class="btn danger"
                                        href="readPet.php?id=<?= (int)$p['idpet'] ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pet ini?')">Hapus</a>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>

        <p class="small">Total data: <?= count($petList) ?></p>
    </div>

</body>

</html>