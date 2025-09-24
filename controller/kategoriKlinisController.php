<?php
require_once 'C:/xampp/htdocs/RSH/model/KategoriKlinisModel.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class KategoriKlinisController
{
    private $model;
    public function __construct()
    {
        $this->model = new KategoriKlinisModel();
    }

    public function index()
    {
        return $this->model->getAll();
    }
    public function getById($id)
    {
        return $this->model->getById($id);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama_kategori_klinis'])) {
            $nama = trim($_POST['nama_kategori_klinis']);
            if ($nama === '') {
                $_SESSION['error'] = 'Nama kategori klinis tidak boleh kosong!';
            } else {
                $ok = $this->model->create($nama);
                $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Kategori klinis berhasil ditambahkan!' : 'Gagal menambah kategori klinis!';
            }
            header("Location: /rsh/pageAdmin/pagekategoriklinis/readKategoriKlinis.php");
            exit();
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama_kategori_klinis'])) {
            $nama = trim($_POST['nama_kategori_klinis']);
            $ok = $this->model->update($id, $nama);
            $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Kategori klinis berhasil diperbarui!' : 'Gagal memperbarui kategori klinis!';
            header("Location: /rsh/pageAdmin/pagekategoriklinis/readKategoriKlinis.php");
            exit();
        }
    }

    public function delete($id)
    {
        $ok = $this->model->delete($id);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Kategori klinis berhasil dihapus!' : 'Gagal menghapus kategori klinis!';
        header("Location: /rsh/pageAdmin/pagekategoriklinis/readKategoriKlinis.php");
        exit();
    }
}
