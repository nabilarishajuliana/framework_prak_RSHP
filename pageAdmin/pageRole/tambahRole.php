<?php
// session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
//     header('Location: loginView.php'); exit();
// }
// require_once '../../controller/RoleController.php';
// $controller = new RoleController();

// $iduser = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// $user   = $controller->getUserBasic($iduser);

// /* Submit tambah role */
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $controller->addRole($iduser);
//     exit;
// }

// $availableRoles = $controller->listAvailableRoles($iduser);

// /* Flash */
// $msg = $_SESSION['message'] ?? null;
// $err = $_SESSION['error'] ?? null;
// unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Role User</title>
  <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>
<body>
<?php include '../Navbar.php'; ?>

<div class="container">
  <div class="header">
    <h1>Tambah Role untuk: <?= htmlspecialchars($user['nama']) ?></h1>
    <a class="btn secondary" href="manajemenrole.php">Kembali</a>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form class="card" method="post">
    <div class="field">
      <label>Pilih Role</label>
      <select name="idrole" required>
        <option value="">-- pilih --</option>
        <?php foreach ($availableRoles as $r): ?>
          <option value="<?= (int)$r['idrole'] ?>"><?= htmlspecialchars($r['nama_role']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="footer-actions">
      <a class="btn secondary" href="manajemenrole.php">Batal</a>
      <button class="btn" type="submit">Tambah</button>
    </div>
  </form>

  <?php if (empty($availableRoles)): ?>
    <p class="small">Semua role sudah terpasang pada user ini.</p>
  <?php endif; ?>
</div>
</body>
</html>
