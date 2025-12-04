<?php

// /controller/loginControl.php
require_once '../model/userModel.php'; // sesuaikan jika foldermu /models

class LoginControl
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new userModel();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $email    = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validasi simple
        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Email dan password wajib diisi.';
            $_SESSION['old_email'] = $email;
            header('Location: ../pageCover/login.php'); exit();
        }

        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // set session login
            $_SESSION['logged_in'] = true;
            $_SESSION['idrole_user']    = $user['idrole_user'];
            $_SESSION['iduser']    = $user['iduser'];
            $_SESSION['username']  = $user['email'];
            $_SESSION['nama']      = $user['nama'];
            $_SESSION['role']      = $user['nama_role'];

            // arahkan sesuai role
            switch ($_SESSION['role']) {
                case 'Administrator':
                    header('Location: ../pageAdmin/admin.php'); exit;
                case 'Dokter':
                    header('Location: ../pageDokter/dokter.php'); exit;
                case 'Perawat':
                    header('Location: ../pagePerawat/perawat.php'); exit;
                case 'Resepsionis':
                    header('Location: ../pageResepsionis/resepsionis.php'); exit;
                default:
                    // fallback kalau role tak dikenali
                    header('Location: ../pageAdmin/admin.php'); exit;
            }
        }

        // gagal login
        $_SESSION['error'] = 'Email atau password salah.';
        $_SESSION['old_email'] = $email;
        header('Location: ../pageCover/login.php'); exit();
    }

    // opsional: logout sederhana
    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_unset();
        session_destroy();
        header('Location: ../pageCover/login.php'); exit();
    }
}


?>
