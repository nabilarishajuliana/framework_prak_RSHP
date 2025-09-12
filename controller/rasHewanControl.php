<?php
require_once 'C:/xampp/htdocs/RSH/model/RasHewanModel.php';
session_start();

class RasHewanController
{
    private $model;

    public function __construct()
    {
        $this->model = new RasHewanModel();
    }

    /* ------- VIEW AKAN MENGGUNAKAN INI ------- */

    // List semua ras (sudah join dengan jenis)
    public function index(): array
    {
        return $this->model->getAllRas();
    }

    // Ambil 1 ras by id (untuk form edit)
    public function getById(int $idras_hewan): ?array
    {
        return $this->model->getRasById($idras_hewan);
    }

    // Ambil semua jenis (untuk dropdown)
    public function listJenis(): array
    {
        return $this->model->getAllJenis();
    }

    // Create ras
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['nama_ras'], $_POST['idjenis_hewan'])) {

            $nama_ras = trim($_POST['nama_ras']);
            $idjenis  = (int) $_POST['idjenis_hewan'];

            if ($nama_ras !== '' && $idjenis > 0) {
                if ($this->model->createRas($nama_ras, $idjenis)) {
                    $_SESSION['message'] = "Ras hewan berhasil ditambahkan.";
                } else {
                    $_SESSION['error'] = "Gagal menambahkan ras hewan.";
                }
            } else {
                $_SESSION['error'] = "Nama ras & jenis hewan wajib diisi.";
            }
        }
        header("Location: /rsh/pageAdmin/pagerashewan/readRasHewan.php");
        exit();
    }

    // Update ras
    public function update(int $idras_hewan): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['nama_ras'], $_POST['idjenis_hewan'])) {

            $nama_ras = trim($_POST['nama_ras']);
            $idjenis  = (int) $_POST['idjenis_hewan'];

            if ($nama_ras !== '' && $idjenis > 0) {
                if ($this->model->updateRas($idras_hewan, $nama_ras, $idjenis)) {
                    $_SESSION['message'] = "Ras hewan berhasil diperbarui.";
                } else {
                    $_SESSION['error'] = "Gagal memperbarui ras hewan.";
                }
            } else {
                $_SESSION['error'] = "Data tidak lengkap.";
            }
        }
        header("Location: /rsh/pageAdmin/pagerashewan/readRasHewan.php");
        exit();
    }

    // Delete ras
    public function delete(int $idras_hewan): void
    {
        $result = $this->model->deleteRas($idras_hewan);

        if ($result['ok'] ?? false) {
            $_SESSION['message'] = "Ras hewan berhasil dihapus.";
        } else {
            $msg = $result['message'] ?? 'Gagal menghapus ras hewan.';
            $_SESSION['error'] = $msg;
        }

        header("Location: /rsh/pageAdmin/pagerashewan/readRasHewan.php");
        exit();
    }
}
