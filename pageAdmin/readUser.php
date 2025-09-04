<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
    header('Location: loginView.php');
    exit();
}

require_once '../controller/userController.php';
$controller = new UserController();
$users = $controller->index();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data User - Rumah Sakit Hewan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .alert {
            padding: 10px 15px;
            background-color: #2ecc71;
            color: white;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .topbar {
            text-align: right;
            margin-bottom: 15px;
        }

        .btn {
            padding: 7px 15px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-size: 14px;
            margin-left: 5px;
        }

        .btn-primary {
            background-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        .link-edit,
        .link-danger {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
            color: white;
        }

        .link-edit {
            background-color: #27ae60;
        }

        .link-edit:hover {
            background-color: #1e8449;
        }

        .link-danger {
            background-color: #e74c3c;
        }

        .link-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <h1>Manajemen Data User</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?php
                echo htmlspecialchars($_SESSION['message']);
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="topbar">
            <a href="tambahUser.php" class="btn btn-primary">Tambah User</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users && count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo (int)$user['iduser']; ?></td>
                            <td><?php echo htmlspecialchars($user['nama']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a class="link-edit" href="edituser.php?id=<?php echo (int)$user['iduser']; ?>">Edit</a>
                                <a class="link-danger" href="resetPass.php?id=<?php echo (int)$user['iduser']; ?>" onclick="return confirm('Apakah Anda yakin ingin mereset password user ini?')">Reset Password</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Belum ada data user.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>