<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'Administrator') {
    header('Location: loginView.php');
    exit();
}

// Panggil controller
require_once '../controller/UserController.php';
$controller = new UserController();


// Ambil ID dari query string
$iduser = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data user untuk ditampilkan di form
$user_data = $controller->getUser($iduser);

// Jika POST, jalankan update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->update($iduser);
}

if (!empty($error))

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit User - Rumah Sakit Hewan</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
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

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="text"] {
            width: 95%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            margin-left: 8px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
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

        .form-control-static {
            padding: 8px 0;
            color: #555;
        }
    </style>
</head>

<body>
    <?php include 'Navbar.php'; ?>
    <div class="container">
        <h1>Edit User</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>ID User:</label>
                <div class="form-control-static"><?php echo $user_data['iduser']; ?></div>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <div class="form-control-static"><?php echo $user_data['email']; ?> (tidak dapat diubah)</div>
            </div>

            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user_data['nama']); ?>" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Update" class="btn btn-success">
                <a href="readUser.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>