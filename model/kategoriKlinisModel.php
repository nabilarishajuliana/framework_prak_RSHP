<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class KategoriKlinisModel {
    private $conn;
    public function __construct() { $this->conn = (new Database())->getConnection(); }

    public function create($nama) {
        $stmt = $this->conn->prepare("INSERT INTO kategori_klinis (nama_kategori_klinis) VALUES (?)");
        $stmt->bind_param("s", $nama);
        return $stmt->execute();
    }
    public function getAll() {
        $res = $this->conn->query("SELECT * FROM kategori_klinis ORDER BY idkategori_klinis ASC");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM kategori_klinis WHERE idkategori_klinis=?");
        $stmt->bind_param("i", $id); $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($id, $nama) {
        $stmt = $this->conn->prepare("UPDATE kategori_klinis SET nama_kategori_klinis=? WHERE idkategori_klinis=?");
        $stmt->bind_param("si", $nama, $id);
        return $stmt->execute();
    }
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM kategori_klinis WHERE idkategori_klinis=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
