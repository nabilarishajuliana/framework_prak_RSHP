<?php
require_once 'C:/xampp/htdocs/RSH/controller/RoleLogincheck.php';
new RoleLoginCheck('Administrator');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- pake stylesheet global admin -->
  <link rel="stylesheet" href="../Assets/admin.css" />
</head>
<body>

  <?php include "Navbar.php"; ?>

  <div class="container">
    <div class="header">
      <div>
        <h1>Dashboard Admin</h1>
        <p class="muted">Kelola data aplikasi klinik hewan kamu dari satu tempat.</p>
      </div>
    </div>

    <!-- GRID MENU -->
    <div class="menu-grid">
      <a class="menu-tile" href="/rsh/pageAdmin/pageUser/readUser.php" aria-label="Data User">
        <span class="tile-emoji">👤</span>
        <span class="tile-title">Data User</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pageRole/manajemenRole.php" aria-label="Manajemen Role">
        <span class="tile-emoji">🛡️</span>
        <span class="tile-title">Manajemen Role</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pageJenisHewan/readJenisHewan.php" aria-label="Jenis Hewan">
        <span class="tile-emoji">🐾</span>
        <span class="tile-title">Jenis Hewan</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pageRasHewan/readRasHewan.php" aria-label="Ras Hewan">
        <span class="tile-emoji">📚</span>
        <span class="tile-title">Ras Hewan</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pagePemilik/readPemilik.php" aria-label="Pemilik">
        <span class="tile-emoji">🏠</span>
        <span class="tile-title">Pemilik</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pagePet/readPet.php" aria-label="Pet">
        <span class="tile-emoji">🐶</span>
        <span class="tile-title">Pet</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pagetemudokter/readTemuDokter.php" aria-label="Temu Dokter">
        <span class="tile-emoji">🩺</span>
        <span class="tile-title">Temu Dokter</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pageKategori/readKategori.php" aria-label="Kategori">
        <span class="tile-emoji">🏷️</span>
        <span class="tile-title">Kategori</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pageKategoriKlinis/readKategoriKlinis.php" aria-label="Kategori Klinis">
        <span class="tile-emoji">🧬</span>
        <span class="tile-title">Kategori Klinis</span>
      </a>

      <a class="menu-tile" href="/rsh/pageAdmin/pageKodeTindakan/readKodeTindakan.php" aria-label="Kode Tindakan">
        <span class="tile-emoji">🧾</span>
        <span class="tile-title">Kode Tindakan</span>
      </a>

      <!-- <a class="menu-tile" href="/rsh/pageAdmin/pageRekamMedis/readRekamMedis.php" aria-label="Kode Tindakan">
        <span class="tile-emoji">🧾</span>
        <span class="tile-title">rekam Medis</span>
      </a> -->
    </div>
  </div>

</body>
</html>
