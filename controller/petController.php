<?php
require_once 'C:/xampp/htdocs/RSH/model/PetModel.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class PetController {
    private $petModel;

    public function __construct() {
        $this->petModel = new PetModel();
    }

    public function index() {
        return $this->petModel->getAllPet();
    }

    public function get($idpet) {
        return $this->petModel->getPetById($idpet);
    }

    public function create($data) {
        if (empty($data['nama']) || empty($data['tanggal_lahir']) || 
            empty($data['warna_tanda']) || empty($data['jenis_kelamin']) || 
            empty($data['idpemilik']) || empty($data['idras_hewan'])) {
            $_SESSION['error'] = 'Semua field wajib diisi.';
            return false;
        }

        if ($this->petModel->createPet(
            $data['nama'], $data['tanggal_lahir'], $data['warna_tanda'], 
            $data['jenis_kelamin'], $data['idpemilik'], $data['idras_hewan']
        )) {
            $_SESSION['message'] = 'Pet berhasil ditambahkan.';
            return true;
        }

        $_SESSION['error'] = 'Gagal menambahkan pet.';
        return false;
    }

    public function update($idpet, $data) {
        if ($this->petModel->updatePet(
            $idpet, $data['nama'], $data['tanggal_lahir'], $data['warna_tanda'], 
            $data['jenis_kelamin'], $data['idpemilik'], $data['idras_hewan']
        )) {
            $_SESSION['message'] = 'Pet berhasil diupdate.';
            return true;
        }

        $_SESSION['error'] = 'Gagal update pet.';
        return false;
    }

    public function delete($idpet) {
        if ($this->petModel->deletePet($idpet)) {
            $_SESSION['message'] = 'Pet berhasil dihapus.';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pet.';
        }
        header("Location: /rsh/pageAdmin/pagePet/readPet.php");
        exit();
    }
}
