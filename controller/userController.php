<?php
require_once 'C:/xampp/htdocs/RSH/model/UserModel.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /* READ list */
    public function index(): array
    {
        return $this->userModel->getAllUsers() ?? [];
    }

    /* READ single (untuk form edit/reset) */
    public function getUser(int $iduser): array
    {
        $user = $this->userModel->getUserById($iduser);
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan!';
            header('Location: /RSH/pageAdmin/pageUser/readUser.php');
            exit();
        }
        return $user;
    }

    /* CREATE */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $nama  = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $pass  = $_POST['password'] ?? '';
        $re    = $_POST['retype_password'] ?? '';

        if ($nama === '' || $email === '' || $pass === '' || $re === '') {
            $_SESSION['error'] = 'Semua field wajib diisi.';
            header('Location: /RSH/pageAdmin/pageUser/tambahUser.php');
            exit();
        }
        if ($pass !== $re) {
            $_SESSION['error'] = 'Password dan ulangi password tidak sama.';
            header('Location: /RSH/pageAdmin/pageUser/tambahUser.php');
            exit();
        }
        if ($this->userModel->checkEmailExists($email)) {
            $_SESSION['error'] = 'Email sudah terdaftar.';
            header('Location:/RSH/pageAdmin/pageUser/tambahUser.php');
            exit();
        }

        if ($this->userModel->createUser($nama, $email, $pass)) {
            $_SESSION['message'] = 'User berhasil ditambahkan.';
            header('Location: /RSH/pageAdmin/pageUser/readUser.php');
            exit();
        } else {
            $_SESSION['error'] = 'Gagal menambahkan user.';
            header('Location: /RSH/pageAdmin/pageUser/tambahUser.php');
            exit();
        }
    }

    /* UPDATE (nama) */
    public function update(int $iduser): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $nama = $_POST['nama'] ?? '';
        if ($nama === '') {
            $_SESSION['error'] = 'Nama tidak boleh kosong.';
            header("Location: /RSH/pageAdmin/pageUser/edituser.php?id={$iduser}");
            exit();
        }

        if ($this->userModel->updateUser($iduser, $nama)) {
            $_SESSION['message'] = 'Data user berhasil diupdate.';
            header('Location: /RSH/pageAdmin/pageUser/readUser.php');
            exit();
        } else {
            $_SESSION['error'] = 'Gagal mengupdate data user.';
            header("Location:/RSH/pageAdmin/pageUser/edituser.php?id={$iduser}");
            exit();
        }
    }

    /* RESET PASSWORD */
    public function resetPassword(int $iduser): void
    {

        // pastikan user ada
        $user = $this->userModel->getUserById($iduser);
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan!';
            header('Location: /RSH/pageAdmin/pageUser/readUser.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $pass = $_POST['password'] ?? '';
        $re   = $_POST['retype_password'] ?? '';

        if ($pass === '' || $re === '') {
            $_SESSION['error'] = 'Password dan ulangi password wajib diisi.';
            header("Location: /RSH/pageAdmin/pageUser/resetPass.php?id={$iduser}");
            exit();
        }
        if ($pass !== $re) {
            $_SESSION['error'] = 'Password dan ulangi password tidak sama.';
            header("Location: /RSH/pageAdmin/pageUser/resetPass.php?id={$iduser}");
            exit();
        }

        if ($this->userModel->updatePassword($iduser, $pass)) {
            $_SESSION['message'] = 'Password berhasil diupdate.';
            header('Location: /RSH/pageAdmin/pageUser/readUser.php');
            exit();
        } else {
            $_SESSION['error'] = 'Gagal mengupdate password.';
            header("Location: /RSH/pageAdmin/pageUser/resetPass.php?id={$iduser}");
            exit();
        }
    }
}
