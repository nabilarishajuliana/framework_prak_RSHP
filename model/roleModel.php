<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class Role
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getAllUsersWithRoles(): array
    {
        $sql = "
        SELECT 
            u.iduser, u.nama,
            r.idrole, r.nama_role, ru.status
        FROM user u
        LEFT JOIN role_user ru ON u.iduser = ru.iduser
        LEFT JOIN role r       ON ru.idrole = r.idrole
        ORDER BY u.iduser DESC, r.nama_role ASC
    ";
        $res = $this->conn->query($sql);

        $users = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $id = (int)$row['iduser'];
                if (!isset($users[$id])) {
                    $users[$id] = [
                        'iduser' => $id,
                        'nama'   => $row['nama'],
                        'roles'  => [] // boleh kosong (user belum punya role)
                    ];
                }
                // Kalau idrole NULL, berarti user ini belum punya role → skip push role
                if (!is_null($row['idrole'])) {
                    $users[$id]['roles'][] = [
                        'idrole'    => (int)$row['idrole'],
                        'nama_role' => $row['nama_role'],
                        'status'    => (int)$row['status'],
                    ];
                }
            }
        }
        return $users;
    }


    /* === LIST SEMUA ROLE === */
    public function getAllRoles(): array
    {
        $sql = "SELECT idrole, nama_role FROM role ORDER BY nama_role";
        $res = $this->conn->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    /* === LIST ROLE user === */
    public function getRolesByUser(int $iduser): array
    {
        $sql = "SELECT r.idrole, r.nama_role, ru.status
                  FROM role_user ru
                  JOIN role r ON r.idrole = ru.idrole
                 WHERE ru.iduser = ?
              ORDER BY r.nama_role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $iduser);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /* === USER (untuk judul halaman) === */
    public function getUserById(int $iduser): ?array
    {
        $sql = "SELECT iduser, nama, email FROM user WHERE iduser = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $iduser);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    /* === ROLE yang belum dimiliki user === */
    public function getAvailableRolesForUser(int $iduser): array
    {
        $sql = "SELECT r.idrole, r.nama_role
                  FROM role r
                 WHERE r.idrole NOT IN (
                       SELECT ru.idrole FROM role_user ru WHERE ru.iduser = ?
                 )
              ORDER BY r.nama_role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $iduser);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /* === Tambah role ke user (status default 0 / non-aktif) === */
    public function addRoleForUser(int $iduser, int $idrole): array
    {
        // cek duplikat
        $sql = "SELECT 1 FROM role_user WHERE iduser = ? AND idrole = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $iduser, $idrole);
        $stmt->execute();
        if ($stmt->get_result()->fetch_row()) {
            return ['ok' => false, 'message' => 'Role sudah terpasang pada user ini.'];
        }

        $sql = "INSERT INTO role_user (iduser, idrole, status) VALUES (?, ?, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $iduser, $idrole);
        if ($stmt->execute()) {
            return ['ok' => true];
        }
        return ['ok' => false, 'message' => $stmt->error];
    }

    /* === Set 1 role aktif untuk user === */
    // public function setActiveRole(int $iduser, int $idrole): array
    // {
    //     try {
    //         $this->conn->begin_transaction();

    //         // non-aktifkan semua role user
    //         $sql = "UPDATE role_user SET status = 0 WHERE iduser = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->bind_param("i", $iduser);
    //         if (!$stmt->execute()) throw new Exception($stmt->error);

    //         // aktifkan role yang dipilih (jika belum ada, buat baru)
    //         $sql = "UPDATE role_user SET status = 1 WHERE iduser = ? AND idrole = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->bind_param("ii", $iduser, $idrole);
    //         if (!$stmt->execute()) throw new Exception($stmt->error);

    //         if ($stmt->affected_rows === 0) {
    //             $this->conn->rollback();
    //             return ['ok' => false, 'message' => 'User belum memiliki role tersebut. Tambahkan role dulu.'];
    //         }

    //         $this->conn->commit();
    //         return ['ok' => true];
    //     } catch (Exception $e) {
    //         $this->conn->rollback();
    //         return ['ok' => false, 'message' => $e->getMessage()];
    //     }
    // }

    public function listActiveWithUser(): array
    {
        $sql = "
        SELECT 
            ru.idrole_user,
            ru.idrole,
            ru.status,
            u.iduser,             
            u.nama AS nama_user,
            u.email,
            r.nama_role
        FROM role_user ru
        JOIN user u ON u.iduser = ru.iduser
        JOIN role r ON r.idrole = ru.idrole
        WHERE ru.status = 1 
          AND LOWER(r.nama_role) IN ('administrator','resepsionis')
        ORDER BY u.nama
    ";
        $res = $this->conn->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function setActiveRole(int $iduser, int $idrole): bool
    {
        // Nonaktifkan semua role user
        $this->conn->query("UPDATE role_user SET status = 0 WHERE iduser = " . (int)$iduser);

        // Cek apakah role tsb sudah ada
        $stmt = $this->conn->prepare("SELECT idrole_user FROM role_user WHERE iduser = ? AND idrole = ?");
        $stmt->bind_param("ii", $iduser, $idrole);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();

        if ($r) {
            $stmt2 = $this->conn->prepare("UPDATE role_user SET status = 1 WHERE idrole_user = ?");
            $stmt2->bind_param("i", $r['idrole_user']);
            return $stmt2->execute();
        } else {
            $stmt3 = $this->conn->prepare("INSERT INTO role_user (iduser, idrole, status) VALUES (?,?,1)");
            $stmt3->bind_param("ii", $iduser, $idrole);
            return $stmt3->execute();
        }
    }
}
