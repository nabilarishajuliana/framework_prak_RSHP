<?php
require_once 'C:/xampp/htdocs/RSH/model/TemuDokterModel.php';
require_once 'C:/xampp/htdocs/RSH/model/PetModel.php';
require_once 'C:/xampp/htdocs/RSH/model/RoleModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class TemuDokterController
{
    private $model;
    private $petModel;
    private $roleUserModel;

    public function __construct()
    {
        $this->model        = new TemuDokterModel();
        $this->petModel     = new PetModel();
        $this->roleUserModel = new role();
    }

    // LIST antrian hari ini
    public function index(): array
    {
        return $this->model->getTodayQueues();
    }

    // Dropdown data
    public function listPets(): array
    {
        return $this->petModel->listForDropdown();
    }
    // public function listDokter(): array { return $this->roleUserModel->listActiveWithUser(); }

    // CREATE
    public function create(array $data): bool
    {
        if (empty($data['idpet'])) {
            $_SESSION['error'] = 'Pet wajib dipilih.';
            return false;
        }

        // Ambil id user login (creator)
        if (!isset($_SESSION['idrole_user'])) {
            $_SESSION['error'] = 'Sesi pengguna tidak valid. Silakan login ulang.';
            return false;
        }
        $iduser_creator = (int)$_SESSION['idrole_user'];

        $res = $this->model->createQueue((int)$data['idpet'], $iduser_creator);
        if ($res['ok'] ?? false) {
            $_SESSION['message'] = 'Pendaftaran berhasil. No. Antrian: ' . $res['no_urut'];
            return true;
        }
        $_SESSION['error'] = 'Gagal daftar: ' . ($res['error'] ?? 'unknown');
        return false;
    }


    // Ubah status
    public function setStatus(int $id, string $status): void
    {
        if ($this->model->setStatus($id, $status)) {
            $_SESSION['message'] = 'Status berhasil diubah.';
        } else {
            $_SESSION['error']   = 'Gagal mengubah status.';
        }
        header('Location: /rsh/pageAdmin/pageTemuDokter/readTemuDokter.php');
        exit();
    }

    // Hapus
    public function delete(int $id): void
    {
        $ok = $this->model->delete($id);
        if ($ok) {
            $_SESSION['message'] = 'Antrian berhasil dihapus!';
        }
        header('Location: /rsh/pageAdmin/pageTemuDokter/readTemuDokter.php');
        exit();
    }


    public function getQueuesByPet(int $idpet): array
    {
        return $this->model->getQueuesByPet($idpet);
    }
}
