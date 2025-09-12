<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
    header('Location: loginView.php'); exit();
}
require_once '../controller/RoleController.php';
$controller = new RoleController();

/* Set aktif (POST dari dropdown per user) */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='set_active') {
    $controller->setActive((int)$_POST['iduser']);
}

/* Data */
$users = $controller->getUserRole();

/* Flash */
$msg = $_SESSION['message'] ?? null;
$err = $_SESSION['error'] ?? null;
unset($_SESSION['message'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Role - Rumah Sakit Hewan</title>
  <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>
<body>
<?php include 'Navbar.php'; ?>

<div class="container">
  <div class="header">
    <h1>Manajemen Role User</h1>
  </div>

  <?php if ($msg): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th style="width:90px">ID User</th>
          <th>Nama</th>
          <th>Role Terpasang</th>
          <th style="width:320px">Atur Aktif & Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)): ?>
          <?php foreach ($users as $id => $user): ?>
            <?php
              $roles = $user['roles'];
              $activeId = null;
              foreach ($roles as $r) if ((int)$r['status']===1) { $activeId = (int)$r['idrole']; break; }
            ?>
            <tr>
              <td><?= (int)$id ?></td>
              <td><span class="badge"><?= htmlspecialchars($user['nama']) ?></span></td>
              <td>
                <?php if (!$roles): ?>
                  <span class="small">Belum ada role.</span>
                <?php else: foreach ($roles as $role): ?>
                  <div>
                    <?= htmlspecialchars($role['nama_role']) ?>
                    <?php if ((int)$role['status'] === 1): ?>
                      <span class="badge">Aktif</span>
                    <?php endif; ?>
                  </div>
                <?php endforeach; endif; ?>
              </td>
              <td>
                <!-- Dropdown set role aktif -->
                <form method="post" style="display:flex; gap:8px; align-items:center;">
                  <input type="hidden" name="action" value="set_active">
                  <input type="hidden" name="iduser" value="<?= (int)$id ?>">
                  <select name="idrole" required>
                    <?php foreach ($roles as $role): ?>
                      <option value="<?= (int)$role['idrole'] ?>" <?= ($activeId===(int)$role['idrole'])?'selected':'' ?>>
                        <?= htmlspecialchars($role['nama_role']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <button class="btn secondary" type="submit">Set Aktif</button>
                  <a class="btn" href="tambahRole.php?id=<?= (int)$id ?>">+ Tambah Role</a>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" class="small" style="text-align:center">Belum ada data user/role.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
