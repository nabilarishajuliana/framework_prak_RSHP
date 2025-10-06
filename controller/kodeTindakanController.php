<?php
require_once 'C:/xampp/htdocs/RSH/model/KodeTindakanModel.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class KodeTindakanTerapiController
{
    private $model;
    public function __construct()
    {
        $this->model = new KodeTindakanTerapiModel();
    }

    public function index()
    {
        return $this->model->getAll();
    }
    public function getById($id)
    {
        return $this->model->getById($id);
    }

    // data untuk dropdown
    public function getKategoriOptions()
    {
        return $this->model->getAllKategori();
    }
    public function getKategoriKlinisOptions()
    {
        return $this->model->getAllKategoriKlinis();
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            $desk = trim($_POST['deskripsi'] ?? '');
            $idk  = (int)($_POST['idkategori'] ?? 0);
            $idkk = (int)($_POST['idkategori_klinis'] ?? 0);

            if ($kode === '' || $desk === '' || $idk <= 0 || $idkk <= 0) {
                $_SESSION['error'] = 'Semua field wajib diisi!';
            } else {
                $ok = $this->model->create($kode, $desk, $idk, $idkk);
                $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Kode tindakan/terapi berhasil ditambahkan!' : 'Gagal menambah data!';
            }
            header("Location: /rsh/pageAdmin/pagekodetindakan/readKodeTindakan.php");
            exit();
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            $desk = trim($_POST['deskripsi'] ?? '');
            $idk  = (int)($_POST['idkategori'] ?? 0);
            $idkk = (int)($_POST['idkategori_klinis'] ?? 0);

            $ok = $this->model->update($id, $kode, $desk, $idk, $idkk);
            $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Berhasil memperbarui data!' : 'Gagal memperbarui data!';
            header("Location: /rsh/pageAdmin/pagekodetindakan/readKodeTindakan.php");
            exit();
        }
    }

    public function delete($id)
    {
        $ok = $this->model->delete($id);
        if ($ok) {
            $_SESSION['message'] = 'Kode tindakan berhasil dihapus!';
        }
        header("Location: /rsh/pageAdmin/pagekodetindakan/readKodeTindakan.php");
        exit();
    }
}
