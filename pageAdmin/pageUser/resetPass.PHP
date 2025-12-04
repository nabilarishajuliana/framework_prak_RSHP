<?php
require_once '../../controller/UserController.php';
$controller = new UserController();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'Administrator') {
  header('Location: loginView.php'); exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = $controller->getUser($id);
if ($_SERVER['REQUEST_METHOD']==='POST') { $controller->resetPassword($id); }
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><title>Reset Password</title>
<link rel="stylesheet" href="/rsh/assets/admin.css">
</head><body>
<?php include '../Navbar.php'; ?>
<div class="container">
  <div class="header">
    <h1>Reset Password</h1>
    <a class="btn secondary" href="readUser.php">Kembali</a>
  </div>

  <?php if($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <form class="card" method="post">
    <div class="field">
      <label>Nama</label>
      <div class="input" style="border:none;background:#f9fafb"><?= htmlspecialchars($user['nama']) ?></div>
    </div>
    <div class="field">
      <label>Email</label>
      <div class="input" style="border:none;background:#f9fafb"><?= htmlspecialchars($user['email']) ?></div>
    </div>

    <div class="form-row">
      <div class="field">
        <label>Password Baru</label>
        <input class="input" type="password" name="password" required>
      </div>
      <div class="field">
        <label>Ulangi Password Baru</label>
        <input class="input" type="password" name="retype_password" required>
      </div>
    </div>

    <div class="footer-actions">
      <a class="btn secondary" href="readUser.php">Batal</a>
      <button class="btn" type="submit">Reset Password</button>
    </div>
  </form>
</div>
</body></html>
