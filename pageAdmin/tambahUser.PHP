<?php
// /views/createUserView.php

session_start();

// Memastikan hanya administrator yang dapat mengakses halaman ini
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
    header('Location: loginView.php');
    exit();
}

// Memanggil Controller langsung di dalam View untuk menangani logika
require_once '../controller/UserController.php';
$controller = new UserController();

// Menjalankan proses create user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->create(); // Memanggil metode create() dari controller
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah User - Rumah Sakit Hewan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 95%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .alert {
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <h1>Tambah User Baru</h1>

        <!-- Menampilkan pesan error jika ada -->
        <?php if ($controller->getError()): ?>
            <div class="alert alert-error"><?php echo $controller->getError(); ?></div>
        <?php endif; ?>

        <!-- Menampilkan pesan sukses jika ada -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message'];
                                                unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <form method="POST">
            <table>
                <tr>
                    <td>Nama:</td>
                    <td><input type="text" name="nama" required value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : ''; ?>"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td>Retype Password:</td>
                    <td><input type="password" name="retype_password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Tambah User">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>