<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class TemuDokterModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    /** Ambil semua antrian HARI INI (urut no_urut) */
    public function getTodayQueues(): array
    {
        $sql = "
    SELECT td.idreservasi_dokter, td.no_urut, td.waktu_daftar, td.status,
           p.idpet, p.nama AS nama_pet,
           pm.idpemilik, u_pemilik.nama AS nama_pemilik,
           u_creator.iduser AS iduser_creator, u_creator.nama AS dibuat_oleh
          
    FROM temu_dokter td
    JOIN pet p          ON p.idpet = td.idpet
    JOIN pemilik pm     ON pm.idpemilik = p.idpemilik
    JOIN user u_pemilik ON u_pemilik.iduser = pm.iduser
    JOIN role_user ru ON ru.idrole_user = td.idrole_user
    JOIN user u_creator ON ru.iduser = u_creator.iduser
    WHERE DATE(td.waktu_daftar) = CURDATE()
    ORDER BY  td.waktu_daftar DESC,td.no_urut ";
        $res = $this->conn->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }


    /** Ambil 1 antrian */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM temu_dokter WHERE idreservasi_dokter=? LIMIT 1";
        $st  = $this->conn->prepare($sql);
        $st->bind_param("i", $id);
        $st->execute();
        $row = $st->get_result()->fetch_assoc();
        return $row ?: null;
    }

    /** Hitung next queue hari ini + buat antrian (status default N=New) */
    public function createQueue(int $idpet, int $iduser_creator): array
    {
        $out = ['ok' => false];
        $this->conn->begin_transaction();
        try {
            // kunci perhitungan no_urut per HARI
            $qMax = $this->conn->prepare("
            SELECT COALESCE(MAX(no_urut),0)+1 AS next_no
            FROM temu_dokter
            WHERE DATE(waktu_daftar)=CURDATE()
            FOR UPDATE
        ");
            $qMax->execute();
            $next = (int)$qMax->get_result()->fetch_assoc()['next_no'];

            $ins = $this->conn->prepare("
            INSERT INTO temu_dokter (no_urut, waktu_daftar, status, idpet, idrole_user)
            VALUES (?, NOW(), 'N', ?, ?)
        ");
            $ins->bind_param("iii", $next, $idpet, $iduser_creator);
            $ins->execute();

            $this->conn->commit();
            $out = ['ok' => true, 'no_urut' => $next, 'id' => $this->conn->insert_id];
        } catch (mysqli_sql_exception $e) {
            $this->conn->rollback();
            $out = ['ok' => false, 'error' => $e->getMessage()];
        }
        return $out;
    }


    /** Ubah status: N=new, S=served, B=batal */
    public function setStatus(int $id, string $status): bool
    {
        $sql = "UPDATE temu_dokter SET status=? WHERE idreservasi_dokter=?";
        $st  = $this->conn->prepare($sql);
        $st->bind_param("si", $status, $id);
        return $st->execute();
    }

    /** Hapus antrian */
    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM temu_dokter WHERE idreservasi_dokter = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                $_SESSION['error'] = 'Tidak dapat menghapus data temu dokter karena masih digunakan di tabel rekam medis.';
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan: ' . $e->getMessage();
            }
            return false;
        }
    }



    public function getQueuesByPet(int $idpet): array
    {
        $sql = "SELECT td.idreservasi_dokter, td.no_urut, td.waktu_daftar, td.status,
                   p.idpet, p.nama AS nama_pet
            FROM temu_dokter td
            JOIN pet p ON p.idpet = td.idpet
            WHERE td.idpet = ?
            ORDER BY td.waktu_daftar DESC, td.no_urut ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idpet);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
}
