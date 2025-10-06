<?php
require_once '../model/userModel.php';
require_once '../model/PemilikModel.php';

class LoginControl
{
    private $userModel;
    private $pemilikModel;

    public function __construct()
    {
        $this->userModel = new userModel();
        $this->pemilikModel = new PemilikModel(); // Model pemilik
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $email = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validasi simple
        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Email dan password wajib diisi.';
            $_SESSION['old_email'] = $email;
            header('Location: ../pageCover/login.php');
            exit();
        }

        $user = $this->userModel->getUserByEmail($email);

        // Cek apakah user valid dan password sesuai
        if ($user && password_verify($password, $user['password'])) {
            // set session login
            $_SESSION['logged_in'] = true;
            $_SESSION['idrole_user'] = $user['idrole_user'];
            $_SESSION['iduser'] = $user['iduser'];
            $_SESSION['username'] = $user['email'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['nama_role'];



            // Arahkan berdasarkan role
            switch ($_SESSION['role']) {
                case 'Administrator':
                    header('Location: ../pageAdmin/admin.php');
                    exit;
                case 'Dokter':
                    header('Location: ../pageDokter/dokter.php');
                    exit;
                case 'Perawat':
                    header('Location: ../pagePerawat/perawat.php');
                    exit;
                case 'Resepsionis':
                    header('Location: ../pageResepsionis/resepsionis.php');
                    exit;
                case 'pemilik':  // Role pemilik, tanpa perlu ditambahin ke role table
                    header('Location: ../pagePemilik/pagePet/pets.php');  // Halaman pemilik
                    exit;
                default:
                    $_SESSION['error'] = 'Role tidak dikenali.';
                    header('Location: ../pageCover/login.php');
                    exit;
            }
        }

        $pemilik= $this->pemilikModel->getPemilikByemail($email);


         if  ($pemilik && password_verify($password, $pemilik['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['iduser'] = $pemilik['iduser'];
            $_SESSION['username'] = $pemilik['email'];
            $_SESSION['nama'] = $pemilik['nama'];
            $_SESSION['role'] = "pemilik";
            $_SESSION['pemilik_id'] = $pemilik['idpemilik'];  // Simpan pemilik_id di session

            switch ($_SESSION['role']) {

                case 'pemilik':  // Role pemilik, tanpa perlu ditambahin ke role table
                    header('Location: ../pagePemilik/pemilik.php');  // Halaman pemilik
                    exit;
                default:
                    $_SESSION['error'] = 'Role tidak dikenali.';
                    header('Location: ../pageCover/login.php');
                    exit;
            }
        }

        // Gagal login
        $_SESSION['error'] = 'Email atau password salah.';
        $_SESSION['old_email'] = $email;
        header('Location: ../pageCover/login.php');
        exit();
    }

    // Opsional: logout sederhana
    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_unset();
        session_destroy();
        header('Location: ../pageCover/login.php');
        exit();
    }
}
