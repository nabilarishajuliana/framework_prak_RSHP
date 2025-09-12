<?php
require_once '../controller/UserController.php';
$controller = new UserController();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Administrator') {
  header('Location: loginView.php'); exit();
}

if ($_SERVER['REQUEST_METHOD']==='POST') { $controller->create(); }
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><title>Tambah User</title>
<link rel="stylesheet" href="/rsh/assets/admin.css">
</head><body>
<?php include 'Navbar.php'; ?>
<div class="container">
  <div class="header">
    <h1>Tambah User</h1>
    <a class="btn secondary" href="readUser.php">Kembali</a>
  </div>

  <?php if($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form class="card" method="post">
    <div class="form-row">
      <div class="field">
        <label>Nama</label>
        <input class="input" type="text" name="nama" required
               value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
      </div>
      <div class="field">
        <label>Email</label>
        <input class="input" type="email" name="email" required
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      </div>
    </div>

    <div class="form-row">
      <div class="field">
        <label>Password</label>
        <input class="input" type="password" name="password" required>
      </div>
      <div class="field">
        <label>Ulangi Password</label>
        <input class="input" type="password" name="retype_password" required>
      </div>
    </div>

    <div class="footer-actions">
      <a class="btn secondary" href="readUser.php">Batal</a>
      <button class="btn" type="submit">Simpan</button>
    </div>
  </form>
</div>
</body></html>
