<?php
require_once 'C:/xampp/htdocs/RSH/model/roleModel.php';
require_once 'C:/xampp/htdocs/RSH/model/UserModel.php';

class RoleController
{
    private $roleModel;
    private $userModel;

    public function __construct()
    {
        $this->roleModel = new Role();
        $this->userModel = new UserModel();
    }

    /* === LIST USER DENGAN ROLE AKTIF === */
    public function getAllUsersWithActiveRoleNonPemilik(): array
    {
        return $this->userModel->getAllUsersWithActiveRoleNonPemilik();
    }

    /* === LIST SEMUA ROLE === */
    public function getAllRoles(): array
    {
        return $this->roleModel->getAllRoles();
    }

    public function setActiveRoleSimple(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setrole'])) {
            $iduser = (int)$_POST['iduser'];
            $idrole = (int)$_POST['idrole'];
            $this->roleModel->setActiveRole($iduser, $idrole);
            header("Location: /RSH/pageAdmin/pageRole/manajemenrole.php");
            exit;
        }
    }

    public function getUserRole(): array
    {
        return $this->roleModel->getAllUsersWithRoles();
    }

    // public function getUserBasic(int $iduser): array
    // {
    //     $user = $this->roleModel->getUserById($iduser);
    //     if (!$user) {
    //         if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    //         $_SESSION['error'] = 'User tidak ditemukan.';
    //         header('Location: /RSH/pageAdmin/pageRole/manajemenrole.php');
    //         exit();
    //     }
    //     return $user;
    // }

    // public function listAvailableRoles(int $iduser): array
    // {
    //     return $this->roleModel->getAvailableRolesForUser($iduser);
    // }

    // public function addRole(int $iduser): void
    // {
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    //     if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    //     $idrole = (int)($_POST['idrole'] ?? 0);
    //     if ($idrole <= 0) {
    //         $_SESSION['error'] = 'Silakan pilih role.';
    //         header("Location: /RSH/pageAdmin/pageRole/addRoleUser.php?id={$iduser}");
    //         exit();
    //     }

    //     $res = $this->roleModel->addRoleForUser($iduser, $idrole);
    //     if ($res['ok']) {
    //         $_SESSION['message'] = 'Role berhasil ditambahkan ke user.';
    //         header('Location: /RSH/pageAdmin/pageRole/manajemenrole.php');
    //         exit();
    //     } else {
    //         $_SESSION['error'] = $res['message'] ?? 'Gagal menambah role.';
    //         header("Location: /RSH/pageAdmin/pageRole/addRoleUser.php?id={$iduser}");
    //         exit();
    //     }
    // }

    // public function setActive(int $iduser): void
    // {
    //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    //     if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    //     $idrole = (int)($_POST['idrole'] ?? 0);
    //     if ($idrole <= 0) {
    //         $_SESSION['error'] = 'Role tidak valid.';
    //         header('Location: /RSH/pageAdmin/pageRole/manajemenrole.php');
    //         exit();
    //     }

    //     $res = $this->roleModel->setActiveRole($iduser, $idrole);
    //     if ($res['ok']) {
    //         $_SESSION['message'] = 'Role aktif berhasil diset.';
    //     } else {
    //         $_SESSION['error'] = $res['message'] ?? 'Gagal menyetel role aktif.';
    //     }
    //     header('Location: /RSH/pageAdmin/pageRole/manajemenrole.php');
    //     exit();
    // }
}
