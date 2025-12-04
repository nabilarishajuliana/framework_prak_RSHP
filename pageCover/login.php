<?php
require_once '../controller/loginControl.php';
$controller = new LoginControl();

session_start();

// POST -> controller akan handle + redirect (PRG)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
    exit; // jaga-jaga
}

// Ambil flash message
$msg      = $_SESSION['message'] ?? null;
$err      = $_SESSION['error'] ?? null;
$oldEmail = $_SESSION['old_email'] ?? '';
unset($_SESSION['message'], $_SESSION['error'], $_SESSION['old_email']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Rumah Sakit Hewan</title>
  <link rel="stylesheet" href="/rsh/assets/login.css">
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <h1 class="title">Masuk ke RSH</h1>
      <p class="subtitle">Silakan login menggunakan akun Anda</p>

      <?php if ($msg): ?>
        <div class="alert success"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>
      <?php if ($err): ?>
        <div class="alert error"><?= htmlspecialchars($err) ?></div>
      <?php endif; ?>

      <form method="POST" class="form">
        <div class="field">
          <label>Email</label>
          <input type="email" name="username" class="input" placeholder="nama@contoh.com" required
                 value="<?= htmlspecialchars($oldEmail) ?>">
        </div>

        <div class="field">
          <label>Password</label>
          <input type="password" name="password" class="input" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn">Masuk</button>
      </form>

      <p class="muted">Butuh bantuan? Hubungi admin.</p>
    </div>
  </div>
</body>
</html>
