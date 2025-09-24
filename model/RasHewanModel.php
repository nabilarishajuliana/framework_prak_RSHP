<?php
require_once 'C:/xampp/htdocs/RSH/DB/koneksi.php';

class RasHewanModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    /* ---------- CREATE ---------- */
    public function createRas(string $nama_ras, int $idjenis_hewan): bool
    {
        $sql = "INSERT INTO ras_hewan (nama_ras, idjenis_hewan) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $nama_ras, $idjenis_hewan);
        return $stmt->execute();
    }

    /* ---------- READ (single) ---------- */
    public function getRasById(int $idras_hewan): ?array
    {
        $sql = "SELECT r.*, j.nama_jenis_hewan
                  FROM ras_hewan r
                  JOIN jenis_hewan j ON j.idjenis_hewan = r.idjenis_hewan
                 WHERE r.idras_hewan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idras_hewan);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ?: null;
    }

    /* ---------- READ (all) ---------- */
    public function getAllRas(): array
    {
        $sql = "SELECT r.idras_hewan, r.nama_ras, r.idjenis_hewan, j.nama_jenis_hewan
                  FROM ras_hewan r
                  JOIN jenis_hewan j ON j.idjenis_hewan = r.idjenis_hewan
              ORDER BY j.nama_jenis_hewan, r.nama_ras";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /* ---------- UPDATE ---------- */
    public function updateRas(int $idras_hewan, string $nama_ras, int $idjenis_hewan): bool
    {
        $sql = "UPDATE ras_hewan
                   SET nama_ras = ?, idjenis_hewan = ?
                 WHERE idras_hewan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $nama_ras, $idjenis_hewan, $idras_hewan);
        return $stmt->execute();
    }

    /* ---------- DELETE ---------- */
    public function deleteRas(int $idras_hewan): array
    {
        // Kembalikan ['ok'=>true] bila sukses
        $sql = "DELETE FROM ras_hewan WHERE idras_hewan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idras_hewan);

        if ($stmt->execute()) {
            return ['ok' => true];
        }

        // Tangani error FK (dipakai di tabel pet)
        // 1451 = Cannot delete or update a parent row: a foreign key constraint fails
        $error = $stmt->errno;
        if ($error === 1451) {
            return [
                'ok' => false,
                'code' => 1451,
                'message' => 'Data ras sedang dipakai pada data hewan (pet). Hapus/ubah data terkait terlebih dahulu.'
            ];
        }

        return ['ok' => false, 'code' => $error, 'message' => $stmt->error];
    }

    /* ---------- Helper: list jenis untuk dropdown ---------- */
    public function getAllJenis(): array
    {
        $sql = "SELECT idjenis_hewan, nama_jenis_hewan FROM jenis_hewan ORDER BY nama_jenis_hewan";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    // Tambahkan di class RasHewanModel
public function countPetByRas(int $idras_hewan): int {
    $sql  = "SELECT COUNT(*) AS jml FROM pet WHERE idras_hewan = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idras_hewan);
    $stmt->execute();
    return (int)$stmt->get_result()->fetch_assoc()['jml'];
}

}
