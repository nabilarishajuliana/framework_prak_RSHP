<?php

require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';


class jenisHewanModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection(); // Mendapatkan koneksi database
    }

    // Create: Menambah user baru
    public function createJenis($nama)
    {
        // Menggunakan parameter binding untuk query yang aman
        $sql = "INSERT INTO jenis_hewan (nama_jenis_hewan) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nama); // Menyambungkan parameter $nama ke query
        return $stmt->execute(); // Eksekusi query
    }


    // Read: Mendapatkan data pengguna berdasarkan ID
    public function getJenisById($id)
    {
         $query = "SELECT * FROM jenis_hewan WHERE idjenis_hewan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Read: Mendapatkan semua data pengguna
    public function getAllJenis()
    {
        $query = "SELECT * FROM jenis_hewan";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function updateJenis($id, $nama_jenis)
    {
        $query = "UPDATE jenis_hewan SET nama_jenis_hewan = ? WHERE idjenis_hewan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $nama_jenis, $id);
        return $stmt->execute(); // Eksekusi query update
    }

    public function deleteJenis($id) {
        $query = "DELETE FROM jenis_hewan WHERE idjenis_hewan = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
