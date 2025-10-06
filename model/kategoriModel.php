<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class KategoriModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function create($nama)
    {
        $sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nama);
        return $stmt->execute();
    }
    public function getAll()
    {
        $res = $this->conn->query("SELECT * FROM kategori ORDER BY idkategori ASC");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM kategori WHERE idkategori=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($id, $nama)
    {
        $stmt = $this->conn->prepare("UPDATE kategori SET nama_kategori=? WHERE idkategori=?");
        $stmt->bind_param("si", $nama, $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM kategori WHERE idkategori = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $_SESSION['error'] = 'Tidak dapat menghapus kategori karena masih digunakan di tabel kode tindakan terapi.';
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            }
            return false;
        }
    }
}
