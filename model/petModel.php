<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class PetModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // CREATE
    public function createPet($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan)
    {
        $sql = "INSERT INTO pet (nama, tanggal_lahir, warna_tanda, jenis_kelamin, idpemilik, idras_hewan)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssii", $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan);
        return $stmt->execute();
    }

    // READ ALL
    public function getAllPet()
    {
        $sql = "SELECT p.idpet, p.nama, p.tanggal_lahir, p.warna_tanda, p.jenis_kelamin, 
                       u.nama AS nama_pemilik, r.nama_ras
                FROM pet p
                INNER JOIN pemilik pem ON p.idpemilik = pem.idpemilik
                INNER JOIN user u ON u.iduser = pem.iduser
                INNER JOIN ras_hewan r ON p.idras_hewan = r.idras_hewan";
        $res = $this->conn->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    // READ BY ID
    public function getPetById($idpet)
    {
        $sql = "SELECT * FROM pet WHERE idpet = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idpet);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE
    public function updatePet($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan)
    {
        $sql = "UPDATE pet 
                SET nama=?, tanggal_lahir=?, warna_tanda=?, jenis_kelamin=?, idpemilik=?, idras_hewan=?
                WHERE idpet=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssiis", $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan, $idpet);
        return $stmt->execute();
    }

    // DELETE
    public function deletePet($idpet)
    {
        $sql = "DELETE FROM pet WHERE idpet=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idpet);
        return $stmt->execute();
    }

    public function listForDropdown(): array
    {
        $sql = "SELECT p.idpet, p.nama AS nama_pet, u.nama AS nama_pemilik
                FROM pet p
                JOIN pemilik pm ON pm.idpemilik = p.idpemilik
                JOIN user u     ON u.iduser    = pm.iduser
                ORDER BY u.nama, p.nama";
        $res = $this->conn->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
}
