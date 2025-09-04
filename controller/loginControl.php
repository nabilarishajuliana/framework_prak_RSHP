<?php

require_once '../model/userModel.php'; // Memasukkan model UserModel

class LoginControl
{
    private $userModel;
    private $error;

    public function __construct()
    {
        $this->userModel = new userModel();
    }

    // Method untuk menangani login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['iduser'] = $user['iduser'];
                $_SESSION['username'] = $user['email'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['nama_role'];

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
                        header('Location: ../pageResepsionis/receptionist.php');
                        exit;
                }
            } else {
                // Hanya set error, jangan panggil showLoginView
                $this->error = 'Email atau password salah!';
            }
        }
    }

    public function getError()
    {
        return $this->error;
    }


    // Method untuk menampilkan halaman login
    private function showLoginView()
    {
        include '../pageCover/login.php'; // Menampilkan view login
    }
}
