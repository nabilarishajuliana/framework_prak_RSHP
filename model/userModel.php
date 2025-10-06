<?php
// /models/UserModel.php

require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class userModel
{
    protected $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection(); // Mendapatkan koneksi database
    }

    // Create: Menambah user baru
    public function createUser($nama, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (nama, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $nama, $email, $hashedPassword);
        return $stmt->execute();
    }

    // Mengecek apakah email sudah ada
    public function checkEmailExists($email)
    {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Read: Mendapatkan data pengguna berdasarkan ID
    public function getUserById($iduser)
    {
        $sql = "SELECT iduser, nama, email FROM user WHERE iduser = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $iduser);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Read: Mendapatkan semua data pengguna
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // buat LOGIN
    public function getUserByEmail($email)
    {
        $sql = "SELECT 
                    u.iduser,
                    u.nama,
                    u.email,
                    u.password,
                    ru.idrole,
                    ru.idrole_user,
                    r.nama_role
                FROM user u
                LEFT JOIN role_user ru ON ru.iduser = u.iduser
                LEFT JOIN role r ON r.idrole = ru.idrole
                WHERE u.email = ?
                  AND ru.status = '1'
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // Mengembalikan data user atau null jika tidak ditemukan
    }

    public function updateUser($iduser, $nama)
    {
        $sql = "UPDATE user SET nama = ? WHERE iduser = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $nama, $iduser);
        return $stmt->execute();
    }

    public function updatePassword($iduser, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = ? WHERE iduser = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $iduser);
        return $stmt->execute();
    }

    // === List user aktif berdasarkan nama role ===
    public function getActiveUsersByRole(string $roleName): array
    {
        $sql = "SELECT u.iduser, u.nama, u.email,ru.idrole_user,r.nama_role
              FROM user u
              JOIN role_user ru ON ru.iduser = u.iduser AND ru.status = 1
              JOIN role r       ON r.idrole = ru.idrole
             WHERE LOWER(r.nama_role) = LOWER(?)
          ORDER BY u.nama";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $roleName);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    // === Shortcut khusus Dokter (aktif) ===
    public function getDoctors(): array
    {
        return $this->getActiveUsersByRole('Dokter');
    }

    //     public function getAllUsersWithActiveRole(): array
    // {
    //     $sql = "SELECT 
    //                 u.iduser, 
    //                 u.nama, 
    //                 u.email,
    //                 r.nama_role AS role_name
    //             FROM user u
    //             LEFT JOIN role_user ru 
    //                 ON u.iduser = ru.iduser AND ru.status = 1
    //             LEFT JOIN role r 
    //                 ON ru.idrole = r.idrole
    //             ORDER BY u.iduser DESC";
    //     $result = $this->conn->query($sql);
    //     return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    // }

    public function getAllUsersWithActiveRoleNonPemilik(): array
    {
        $sql = "SELECT 
                u.iduser, 
                u.nama, 
                u.email,
                r.nama_role AS role_name
            FROM user u
            LEFT JOIN role_user ru 
                ON u.iduser = ru.iduser AND ru.status = 1
            LEFT JOIN role r 
                ON ru.idrole = r.idrole
            WHERE u.iduser NOT IN (
                SELECT iduser FROM pemilik
            )
            ORDER BY u.iduser DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
