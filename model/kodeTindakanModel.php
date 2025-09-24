<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class KodeTindakanTerapiModel {
    private $conn;
    public function __construct() { $this->conn = (new Database())->getConnection(); }

    public function create($kode, $deskripsi, $idkategori, $idkategori_klinis) {
        $sql = "INSERT INTO kode_tindakan_terapi (kode, deskripsi_tindakan_terapi, idkategori, idkategori_klinis)
                VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $kode, $deskripsi, $idkategori, $idkategori_klinis);
        return $stmt->execute();
    }
    public function getAll() {
        $sql = "SELECT ktt.*, k.nama_kategori, kk.nama_kategori_klinis
                FROM kode_tindakan_terapi ktt
                JOIN kategori k ON k.idkategori = ktt.idkategori
                JOIN kategori_klinis kk ON kk.idkategori_klinis = ktt.idkategori_klinis
                ORDER BY ktt.idkode_tindakan_terapi ASC";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM kode_tindakan_terapi WHERE idkode_tindakan_terapi=?");
        $stmt->bind_param("i", $id); $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($id, $kode, $deskripsi, $idkategori, $idkategori_klinis) {
        $sql = "UPDATE kode_tindakan_terapi
                SET kode=?, deskripsi_tindakan_terapi=?, idkategori=?, idkategori_klinis=?
                WHERE idkode_tindakan_terapi=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiii", $kode, $deskripsi, $idkategori, $idkategori_klinis, $id);
        return $stmt->execute();
    }
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM kode_tindakan_terapi WHERE idkode_tindakan_terapi=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // helper untuk dropdown
    public function getAllKategori() {
        $res = $this->conn->query("SELECT idkategori, nama_kategori FROM kategori ORDER BY nama_kategori");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    public function getAllKategoriKlinis() {
        $res = $this->conn->query("SELECT idkategori_klinis, nama_kategori_klinis FROM kategori_klinis ORDER BY nama_kategori_klinis");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
