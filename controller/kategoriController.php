<?php
require_once 'C:/xampp/htdocs/RSH/model/KategoriModel.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class KategoriController
{
    private $model;
    public function __construct()
    {
        $this->model = new KategoriModel();
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama_kategori'])) {
            $nama = trim($_POST['nama_kategori']);
            if ($nama === '') {
                $_SESSION['error'] = 'Nama kategori tidak boleh kosong!';
            } else {
                $ok = $this->model->create($nama);
                $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Kategori berhasil ditambahkan!' : 'Gagal menambah kategori!';
            }
            header("Location: /rsh/pageAdmin/pagekategori/readKategori.php");
            exit();
        }
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama_kategori'])) {
            $nama = trim($_POST['nama_kategori']);
            $ok = $this->model->update($id, $nama);
            $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Kategori berhasil diperbarui!' : 'Gagal memperbarui kategori!';
            header("Location: /rsh/pageAdmin/pagekategori/readKategori.php");
            exit();
        }
    }

    public function delete($id)
    {
        $ok = $this->model->delete($id);
        if ($ok) {
            $_SESSION['message'] = 'Kategori berhasil dihapus!';
        }
        header("Location: /rsh/pageAdmin/pagekategori/readKategori.php");
        exit();
    }
}
