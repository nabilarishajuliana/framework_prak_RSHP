<?php
require_once 'C:/xampp/htdocs/RSH/model/pemilikModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class PemilikController {
    private $pemilikModel;

    public function __construct() {
        $this->pemilikModel = new PemilikModel();
    }

    public function index() {
        return $this->pemilikModel->getAllPemilik();
    }

    public function get($idpemilik) {
        return $this->pemilikModel->getPemilikById($idpemilik);
    }

    public function create($data) {
        if (empty($data['nama']) || empty($data['email']) ||
            empty($data['password']) || empty($data['no_wa']) || empty($data['alamat'])) {
            $_SESSION['error'] = 'Semua field wajib diisi.';
            return false;
        }
        if ($this->pemilikModel->checkEmailExists($data['email'])) {
            $_SESSION['error'] = 'Email sudah terdaftar.';
            return false;
        }

        $this->pemilikModel->setDataPemilik($data['no_wa'], $data['alamat']);
        if ($this->pemilikModel->createUser($data['nama'], $data['email'], $data['password'])) {
            $_SESSION['message'] = 'Pemilik berhasil ditambahkan.';
            return true;
        }
        $_SESSION['error'] = 'Gagal menambahkan pemilik.';
        return false;
    }

    public function update($idpemilik, $data) {
        if ($this->pemilikModel->updatePemilik($idpemilik, $data['nama'], $data['email'], $data['no_wa'], $data['alamat'])) {
            $_SESSION['message'] = 'Data pemilik berhasil diupdate.';
            return true;
        }
        $_SESSION['error'] = 'Gagal update data pemilik.';
        return false;
    }

    public function delete($idpemilik) {
    // 1) Cek dulu ada pet?
    $count = $this->pemilikModel->countPetByPemilik((int)$idpemilik);
    if ($count > 0) {
        $_SESSION['error'] = "Tidak bisa menghapus: pemilik masih memiliki {$count} pet. "
                           . "Hapus/alihtugaskan pet terlebih dahulu.";
        header("Location: /rsh/pageAdmin/pagePemilik/readPemilik.php");
        exit();
    }

    // 2) Lanjut hapus (aman, tidak dipakai pet)
    try {
        if ($this->pemilikModel->deletePemilik((int)$idpemilik)) {
            $_SESSION['message'] = 'Pemilik berhasil dihapus.';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pemilik.';
        }
    } catch (mysqli_sql_exception $e) {
        // Jaga-jaga jika DB tetap menolak (FK RESTRICT)
        if ($e->getCode() === 1451) {
            $_SESSION['error'] = 'Tidak bisa menghapus: data masih direferensikan oleh Pet.';
        } else {
            $_SESSION['error'] = 'Gagal menghapus: '.$e->getMessage();
        }
    }

    header("Location: /rsh/pageAdmin/pagePemilik/readPemilik.php");
    exit();
}

  
}
