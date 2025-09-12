<?php
require_once '../model/UserModel.php';
session_start();

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
            header('Location: ../pageAdmin/readUser.php'); exit();
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
            header('Location: ../pageAdmin/tambahUser.php'); exit();
        }
        if ($pass !== $re) {
            $_SESSION['error'] = 'Password dan ulangi password tidak sama.';
            header('Location: ../pageAdmin/tambahUser.php'); exit();
        }
        if ($this->userModel->checkEmailExists($email)) {
            $_SESSION['error'] = 'Email sudah terdaftar.';
            header('Location: ../pageAdmin/tambahUser.php'); exit();
        }

        if ($this->userModel->createUser($nama, $email, $pass)) {
            $_SESSION['message'] = 'User berhasil ditambahkan.';
            header('Location: ../pageAdmin/readUser.php'); exit();
        } else {
            $_SESSION['error'] = 'Gagal menambahkan user.';
            header('Location: ../pageAdmin/tambahUser.php'); exit();
        }
    }

    /* UPDATE (nama) */
    public function update(int $iduser): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $nama = $_POST['nama'] ?? '';
        if ($nama === '') {
            $_SESSION['error'] = 'Nama tidak boleh kosong.';
            header("Location: ../pageAdmin/edituser.php?id={$iduser}"); exit();
        }

        if ($this->userModel->updateUser($iduser, $nama)) {
            $_SESSION['message'] = 'Data user berhasil diupdate.';
            header('Location: ../pageAdmin/readUser.php'); exit();
        } else {
            $_SESSION['error'] = 'Gagal mengupdate data user.';
            header("Location: ../pageAdmin/edituser.php?id={$iduser}"); exit();
        }
    }

    /* RESET PASSWORD */
    public function resetPassword(int $iduser): void
    {

        // pastikan user ada
        $user = $this->userModel->getUserById($iduser);
        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan!';
            header('Location: ../pageAdmin/readUser.php'); exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $pass = $_POST['password'] ?? '';
        $re   = $_POST['retype_password'] ?? '';

        if ($pass === '' || $re === '') {
            $_SESSION['error'] = 'Password dan ulangi password wajib diisi.';
            header("Location: ../pageAdmin/resetPass.php?id={$iduser}"); exit();
        }
        if ($pass !== $re) {
            $_SESSION['error'] = 'Password dan ulangi password tidak sama.';
            header("Location: ../pageAdmin/resetPass.php?id={$iduser}"); exit();
        }

        if ($this->userModel->updatePassword($iduser, $pass)) {
            $_SESSION['message'] = 'Password berhasil diupdate.';
            header('Location: ../pageAdmin/readUser.php'); exit();
        } else {
            $_SESSION['error'] = 'Gagal mengupdate password.';
            header("Location: ../pageAdmin/resetPass.php?id={$iduser}"); exit();
        }
    }
}
