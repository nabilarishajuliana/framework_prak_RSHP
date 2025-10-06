<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
  header('Location: loginView.php');
  exit();
}
require_once '../../controller/RoleController.php';

$controller = new RoleController();
$controller->setActiveRoleSimple();

$users = $controller->getAllUsersWithActiveRoleNonPemilik();
$roles = $controller->getAllRoles();
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Manajemen Role User (Simple)</title>
  <link rel="stylesheet" href="/rsh/assets/admin.css">
</head>

<body>
  <?php include '../Navbar.php'; ?>
  <div class="container">
    <h1>Manajemen Role User</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role Aktif</th>
          <th>Ganti Role</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['nama']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['role_name'] ?? '-') ?></td>
            <td>
              <form method="post" style="display:flex; gap:8px;">
                <input type="hidden" name="iduser" value="<?= $u['iduser'] ?>">
                <select name="idrole">
                  <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['idrole'] ?>"
                      <?= ($u['role_name'] === $r['nama_role']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($r['nama_role']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <button class="btn" type="submit" name="setrole">Set</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>