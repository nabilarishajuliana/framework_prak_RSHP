<?php
require_once 'C:/xampp/htdocs/RSH/model/jenisHewanModel.php';
session_start();

class JenisHewanController
{

    private $jenisHewanModel;

    public function __construct()
    {
        $this->jenisHewanModel = new jenisHewanModel();
    }

   

    // Menampilkan semua jenis hewan
    public function index()
    {
        return $this->jenisHewanModel->getAllJenis();
    }

    // Menambahkan jenis hewan baru
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_jenis'])) {
            $nama_jenis = $_POST['nama_jenis'];
            // Validasi input dan proses penyimpanan
            if (!empty($nama_jenis)) {
                // Panggil metode untuk menyimpan data jenis hewan baru
                if ($this->jenisHewanModel->createJenis($nama_jenis)) {
                    // Set session message untuk sukses
                    $_SESSION['message'] = "Jenis hewan berhasil ditambahkan!";
                    header("Location: /rsh/pageAdmin/pagejenishewan/readJenisHewan.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal menambahkan jenis hewan!";
                    header("Location: /rsh/pageAdmin/pagejenishewan/readJenisHewan.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Nama jenis hewan tidak boleh kosong!";
                header("Location: /rsh/pageAdmin/pagejenishewan/readJenisHewan.php");
                exit();
            }
        }
        return null; // Untuk menandakan bahwa belum ada data yang diterima
    }

    // Menampilkan data jenis hewan berdasarkan ID
    public function getById($idjenis_hewan)
    {
        return $this->jenisHewanModel->getJenisById($idjenis_hewan);
    }

    // Mengupdate data jenis hewan
     public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_jenis'])) {
            $nama_jenis = $_POST['nama_jenis'];

            // Validasi dan proses update
            if (!empty($nama_jenis)) {
                if ($this->jenisHewanModel->updateJenis($id, $nama_jenis)) {
                    $_SESSION['message'] = "Jenis hewan berhasil diperbarui!";
                    header("Location: /rsh/pageAdmin/pagejenishewan/readJenisHewan.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal memperbarui jenis hewan!";
                    header("Location: /rsh/pageAdmin/pagejenishewan/readJenisHewan.php");
                    exit();
                }
            }
            $_SESSION['error'] = "Data tidak lengkap!";
            header("Location: /rsh/pageAdmin/pagejenishewan/readJenisHewan.php");
            exit();
        }
    }

    // Menghapus data jenis hewan
     public function delete($idjenis_hewan)
    {
        if (!empty($idjenis_hewan)) {
            if ($this->jenisHewanModel->deleteJenis($idjenis_hewan)) {
                $_SESSION['message'] = "Jenis hewan berhasil dihapus!";
            } else {
                $_SESSION['error'] = "Gagal menghapus jenis hewan!";
            }
        } else {
            $_SESSION['error'] = "ID jenis hewan tidak valid!";
        }

        header("Location: /rsh/pageAdmin/pagejenishewan/readJenisHewan.php");
        exit();
    }
}
