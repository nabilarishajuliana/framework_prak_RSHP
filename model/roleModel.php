<?php
require_once '../DB/koneksi.php';

class Role
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection(); // Mendapatkan koneksi database
    }

    // Ambil semua user beserta role-nya
    public function getAllUsersWithRoles()
    {
        $sql = "
            SELECT u.iduser, u.nama, r.nama_role, ru.status
            FROM user u
            JOIN role_user ru ON u.iduser = ru.iduser
            JOIN role r ON ru.idrole = r.idrole
            ORDER BY u.iduser DESC
        ";

        $result = $this->conn->query($sql);
        $users = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $id = (int)$row['iduser'];
                if (!isset($users[$id])) {
                    $users[$id] = [
                        'nama' => $row['nama'],
                        'roles' => []
                    ];
                }
                $users[$id]['roles'][] = [
                    'nama_role' => $row['nama_role'],
                    'status' => (int)$row['status']
                ];
            }
        }

        return $users;
    }
}
