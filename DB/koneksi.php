<?php
// $host = '127.0.0.1'; 
// $user = 'root'; //user database
// $pass = ''; //password database
// $db   = 'framework_prak1'; // nama database

// $conn = new mysqli($host, $user, $pass, $db);
// if ($conn->connect_error) {
//     die('Koneksi gagal: ' . $conn->connect_error);
// }

class Database {
    private $host;
    private $user;
    private $pass;
    private $db;
    private $conn;

    public function __construct(
        $host = 'localhost',
        $user = 'root',
        $pass = '',
        $db   = 'framework_prak1'
    ) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db   = $db;

        // Jangan panggil connect() di konstruktor, panggilnya hanya saat koneksi dibutuhkan
        $this->conn = null; // Tidak langsung membuat koneksi di sini
    }

    // Koneksi hanya dibuat saat dibutuhkan
    public function connect() {
        static $configured = false;
        if (!$configured) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $configured = true;
        }
        if ($this->conn === null) { // Hanya buat koneksi jika belum ada
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
            if ($this->conn->connect_error) {
                throw new Exception('Koneksi gagal: ' . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }

    // Untuk mendapatkan koneksi
    public function getConnection() {
        return $this->connect(); // Pastikan koneksi selalu valid
    }

    // Method untuk menutup koneksi database, hanya dipanggil jika sudah selesai
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
            $this->conn = null;
        }
    }

    public function __destruct() {
        // Tidak perlu menutup koneksi di destruktor jika koneksi masih digunakan di kelas lain
    }
}

?>