<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class RekamMedisModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }


    public function create(int $idReservasiDokter, string $anamnesa, string $temuanKlinis, string $diagnosa, int $dokterPemeriksa) /*: int|false*/
    {
        $sql = "INSERT INTO rekam_medis
            (idReservasi_dokter, anamnesa, temuan_klinis, diagnosa, dokter_pemeriksa, created_at)
            VALUES (?,?,?,?,?, NOW())";
        $st  = $this->conn->prepare($sql);
        $st->bind_param("isssi", $idReservasiDokter, $anamnesa, $temuanKlinis, $diagnosa, $dokterPemeriksa);
        if (!$st->execute()) return false;
        $id = (int)$this->conn->insert_id;
        return $id > 0 ? $id : false;
    }


    /* UPDATE */
    public function update(int $idRekam, string $anamnesa, string $temuanKlinis, string $diagnosa, ?int $dokterPemeriksa = null): bool
    {
        $sql = "UPDATE rekam_medis
                SET anamnesa=?, temuan_klinis=?, diagnosa=?, dokter_pemeriksa=?
                WHERE idrekam_medis=?";
        $st  = $this->conn->prepare($sql);
        $st->bind_param("sssii", $anamnesa, $temuanKlinis, $diagnosa, $dokterPemeriksa, $idRekam);
        return $st->execute();
    }

    /* DELETE: hapus detail dulu, lalu header */
    public function delete(int $idRekam): bool
    {
        $d1 = $this->conn->prepare("DELETE FROM detail_rekam_medis WHERE idrekam_medis=?");
        $d1->bind_param("i", $idRekam);
        $d1->execute();

        $st = $this->conn->prepare("DELETE FROM rekam_medis WHERE idrekam_medis=?");
        $st->bind_param("i", $idRekam);
        return $st->execute();
    }

    /* GET 1: join ke temu_dokter -> pet -> pemilik */
    public function getById(int $idRekam): ?array
    {
        $sql = "SELECT rm.*,
                   td.no_urut, td.waktu_daftar,
                   p.nama  AS nama_pet,
                   upem.nama AS nama_pemilik,
                   udoc.nama AS nama_dokter,
                   p.idpet,
                   pm.idpemilik
            FROM rekam_medis rm
            JOIN temu_dokter td ON td.idreservasi_dokter = rm.idReservasi_dokter
            JOIN pet p          ON p.idpet = td.idpet
            JOIN pemilik pm     ON pm.idpemilik = p.idpemilik
            JOIN user upem      ON upem.iduser = pm.iduser
            JOIN role_user rud  ON rud.idrole_user = rm.dokter_pemeriksa
            JOIN user udoc      ON udoc.iduser = rud.iduser
            WHERE rm.idrekam_medis=?";
        $st = $this->conn->prepare($sql);
        $st->bind_param("i", $idRekam);
        $st->execute();
        $row = $st->get_result()->fetch_assoc();
        return $row ?: null;
    }


    /* LIST all */
    public function getAll(): array
    {
        $sql = "SELECT rm.*,
                   td.no_urut, td.waktu_daftar,
                   p.nama  AS nama_pet,
                   upem.nama AS nama_pemilik,
                   udoc.nama AS nama_dokter
            FROM rekam_medis rm
            JOIN temu_dokter td ON td.idreservasi_dokter = rm.idReservasi_dokter
            JOIN pet p          ON p.idpet = td.idpet
            JOIN pemilik pm     ON pm.idpemilik = p.idpemilik
            JOIN user upem      ON upem.iduser = pm.iduser
            JOIN role_user rud  ON rud.idrole_user = rm.dokter_pemeriksa
            JOIN user udoc      ON udoc.iduser = rud.iduser
                ORDER BY rm.idrekam_medis DESC";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /* Daftar temu_dokter (mis. hari ini) yang BELUM punya rekam_medis */
    public function listTemuDokterUntukRekam(): array
    {
        $sql = "SELECT td.idreservasi_dokter, td.no_urut, td.waktu_daftar,
                       p.nama  AS nama_pet,
                       u.nama AS nama_pemilik
                FROM temu_dokter td
                JOIN pet p      ON p.idpet = td.idpet
                JOIN pemilik pm ON pm.idpemilik = p.idpemilik
                join user u on pm.iduser=u.iduser
                WHERE DATE(td.waktu_daftar) = CURDATE()
                  AND NOT EXISTS (
                      SELECT 1 FROM rekam_medis rm
                      WHERE rm.idReservasi_dokter = td.idreservasi_dokter
                  )
                ORDER BY td.no_urut ASC";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil semua rekam medis untuk pet tertentu
    public function getByPet(int $idpet): array
    {
        $sql = "SELECT rm.*,
                   td.no_urut, td.waktu_daftar,
                   p.nama  AS nama_pet,
                   upem.nama AS nama_pemilik,
                   udoc.nama AS nama_dokter
            FROM rekam_medis rm
            JOIN temu_dokter td ON td.idreservasi_dokter = rm.idReservasi_dokter
            JOIN pet p          ON p.idpet = td.idpet
            JOIN pemilik pm     ON pm.idpemilik = p.idpemilik
            JOIN user upem      ON upem.iduser = pm.iduser
            JOIN role_user rud  ON rud.idrole_user = rm.dokter_pemeriksa
            JOIN user udoc      ON udoc.iduser = rud.iduser
            WHERE p.idpet = ?
            ORDER BY rm.idrekam_medis DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idpet);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
}
