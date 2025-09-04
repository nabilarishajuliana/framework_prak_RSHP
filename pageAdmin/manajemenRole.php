<?php
session_start();

// Cek apakah admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
    header('Location: loginView.php');
    exit();
}

require_once '../controller/RoleController.php';

$controller = new RoleController();
$users = $controller->getUserRole();

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Role - Rumah Sakit Hewan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #3498db;
            color: #fff;
            text-align: left;
        }

        tbody tr:hover {
            background: #f0f0f0;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 12px;
            margin-left: 6px;
        }

        .badge-aktif {
            background: #d1f7d8;
            color: #0f6b2f;
            border: 1px solid #b8eac0;
        }

        .badge-non {
            background: #ffe5e5;
            color: #912626;
            border: 1px solid #f5caca;
        }
    </style>
</head>

<body>

    <?php include 'Navbar.php'; ?>

    <div class="container">
        <h1>Manajemen Role User</h1>

        <table>
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $id => $user): ?>
                        <tr>
                            <td><?php echo (int)$id; ?></td>
                            <td><?php echo htmlspecialchars($user['nama']); ?></td>
                            <td>
                                <?php foreach ($user['roles'] as $role): ?>
                                    <div>
                                        <?php echo htmlspecialchars($role['nama_role']); ?>
                                        <?php if ($role['status'] === 1): ?>
                                            <span class="badge badge-aktif">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-non">Non-Aktif</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <!-- Bisa ditambah tombol edit role nanti -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Belum ada data user/role.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>