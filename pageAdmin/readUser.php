<?php
require_once '../controller/UserController.php';
$controller = new UserController();

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Administrator') {
  header('Location: loginView.php'); exit();
}

$users = $controller->index();
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><title>Data User</title>
<link rel="stylesheet" href="/rsh/assets/admin.css">
</head><body>
<?php include 'Navbar.php'; ?>
<div class="container">
  <div class="header">
    <h1>Manajemen User</h1>
    <a class="btn" href="tambahUser.php">+ Tambah User</a>
  </div>

  <?php if($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <div class="card">
    <table class="table">
      <thead><tr>
        <th style="width:80px">ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th style="width:240px">Aksi</th>
      </tr></thead>
      <tbody>
        <?php if(!$users): ?>
          <tr><td colspan="4" class="small">Belum ada data user.</td></tr>
        <?php else: foreach($users as $u): ?>
          <tr>
            <td><?= (int)$u['iduser'] ?></td>
            <td><span class="badge"><?= htmlspecialchars($u['nama']) ?></span></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td class="actions">
              <a class="btn secondary" href="edituser.php?id=<?= (int)$u['iduser'] ?>">Edit</a>
              <a class="btn danger" href="resetPass.php?id=<?= (int)$u['iduser'] ?>"
                 onclick="return confirm('Reset password untuk user ini?')">Reset Password</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <p class="small">Total user: <?= $users ? count($users) : 0; ?></p>
</div>
</body></html>
