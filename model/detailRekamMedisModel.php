<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class DetailRekamMedisModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getByRekam(int $idRekam): array
    {
        $sql = "SELECT drm.*,
                       ktt.kode,
                       ktt.deskripsi_tindakan_terapi
                FROM detail_rekam_medis drm
                JOIN kode_tindakan_terapi ktt
                  ON ktt.idkode_tindakan_terapi = drm.idkode_tindakan_terapi
                WHERE drm.idrekam_medis=?
                ORDER BY drm.iddetail_rekam_medis ASC";
        $st = $this->conn->prepare($sql);
        $st->bind_param("i", $idRekam);
        $st->execute();
        return $st->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOne(int $iddetail): ?array
    {
        $st = $this->conn->prepare("SELECT * FROM detail_rekam_medis WHERE iddetail_rekam_medis=?");
        $st->bind_param("i", $iddetail);
        $st->execute();
        $row = $st->get_result()->fetch_assoc();
        return $row ?: null;
    }

    /* CREATE: tidak ada qty di skema, gunakan kolom `detail` sebagai catatan */
    public function create(int $idRekam, int $idKode, string $detail): bool
    {
        $sql = "INSERT INTO detail_rekam_medis (idrekam_medis, idkode_tindakan_terapi, detail)
                VALUES (?,?,?)";
        $st = $this->conn->prepare($sql);
        $st->bind_param("iis", $idRekam, $idKode, $detail);
        return $st->execute();
    }

    public function update(int $iddetail, int $idKode, string $detail): bool
    {
        $sql = "UPDATE detail_rekam_medis
                   SET idkode_tindakan_terapi=?, detail=?
                 WHERE iddetail_rekam_medis=?";
        $st = $this->conn->prepare($sql);
        $st->bind_param("isi", $idKode, $detail, $iddetail);
        return $st->execute();
    }

    public function delete(int $iddetail): bool
    {
        $st = $this->conn->prepare("DELETE FROM detail_rekam_medis WHERE iddetail_rekam_medis=?");
        $st->bind_param("i", $iddetail);
        return $st->execute();
    }
}
