<?php
// /controller/UserController.php

require_once '../model/UserModel.php';

class UserController
{
    private $userModel;
    private $error;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->getAllUsers();
        return $users;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $retype_password = $_POST['retype_password'];

            if ($password !== $retype_password) {
                $this->error = "Password dan retype password tidak sama!";
            } elseif ($this->userModel->checkEmailExists($email)) {
                $this->error = "Email sudah terdaftar!";
            } elseif ($this->userModel->createUser($nama, $email, $password)) {
                $_SESSION['message'] = "User berhasil ditambahkan!";
                header("Location: ../pageAdmin/readUser.php");
                exit();
            } else {
                $this->error = "Gagal menambahkan user baru!";
            }
        }

        $this->showCreateForm();
    }

    private function showCreateForm()
    {
        include '../pageAdmin/tambahUser.php';
    }

    // ================== EDIT USER ==================
    public function getUser($iduser)
    {
        // Ambil data user untuk ditampilkan di form
        $user_data = $this->userModel->getUserById($iduser);
        if (!$user_data) {
            $_SESSION['message'] = "User tidak ditemukan!";
            header("Location: ../pageAdmin/readUser.php");
            exit();
        }

        return $user_data;
    }

    public function update($iduser)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];

            if ($this->userModel->updateUser($iduser, $nama)) {
                $_SESSION['message'] = "Data user berhasil diupdate!";
                header("Location: ../pageAdmin/readUser.php");
                exit();
            } else {
                $this->error = "Gagal mengupdate data user!";
            }
        }
    }

    public function resetPassword($iduser)
    {
        // Ambil data user
        $user_data = $this->userModel->getUserById($iduser);
        if (!$user_data) {
            $_SESSION['message'] = "User tidak ditemukan!";
            header("Location: ../pageAdmin/readUser.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $retype_password = $_POST['retype_password'];

            if ($password !== $retype_password) {
                $this->error = "Password dan retype password tidak sama!";
            } elseif ($this->userModel->updatePassword($iduser, $password)) {
                $_SESSION['message'] = "Password berhasil diupdate!";
                header("Location: ../pageAdmin/readUser.php");
                exit();
            } else {
                $this->error = "Gagal mengupdate password!";
            }
        }

        $this->showResetForm($user_data);
    }

    private function showResetForm($user_data)
    {
        include '../pageAdmin/resetPass.php';
    }

    public function getError()
    {
        return $this->error;
    }
}
