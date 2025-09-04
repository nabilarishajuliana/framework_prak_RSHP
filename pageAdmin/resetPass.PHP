<?php
session_start();
require_once '../controller/UserController.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
    header('Location: loginView.php');
    exit();
}

if (!isset($_GET['id'])) {
    $_SESSION['message'] = "ID user tidak ditemukan!";
    header("Location: readUser.php");
    exit();
}

$iduser = (int)$_GET['id'];
$controller = new UserController();

// Ambil data user untuk ditampilkan di form
$user_data = $controller->getUser($iduser);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->resetPassword(iduser: $iduser);
}

$error = $controller->getError();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - Rumah Sakit Hewan</title>
    <style>
        /* ===== Reset CSS ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f8;
            color: #333;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #34495e;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="password"]:focus {
            border-color: #3498db;
            outline: none;
        }

        .form-control-static {
            padding: 10px 12px;
            background-color: #ecf0f1;
            border-radius: 5px;
            font-size: 14px;
            color: #2c3e50;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-success {
            background-color: #2ecc71;
            color: white;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .alert-error {
            background-color: #e74c3c;
            color: white;
            padding: 10px 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .container {
                margin: 30px 15px;
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <div class="container">
        <h1>Reset Password</h1>

        <?php if (isset($error) && $error != ""): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nama:</label>
                <div class="form-control-static"><?php echo htmlspecialchars($user_data['nama']); ?></div>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <div class="form-control-static"><?php echo htmlspecialchars($user_data['email']); ?></div>
            </div>

            <div class="form-group">
                <label>Password Baru:</label>
                <input type="password" name="password" placeholder="Masukkan password baru" required>
            </div>

            <div class="form-group">
                <label>Ulangi Password Baru:</label>
                <input type="password" name="retype_password" placeholder="Ulangi password baru" required>
            </div>

            <div class="form-group" style="text-align: center;">
                <input type="submit" value="Reset Password" class="btn btn-success">
                <a href="readUser.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>