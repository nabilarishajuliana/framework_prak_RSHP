<?php
require_once 'UserModel.php';

class PemilikModel extends UserModel
{
    private $no_wa;
    private $alamat;

    public function setDataPemilik($no_wa, $alamat)
    {
        $this->no_wa  = $no_wa;
        $this->alamat = $alamat;
    }

    public function createUser($nama, $email, $password)
    {
        $this->conn->begin_transaction();
        try {
            if (!parent::createUser($nama, $email, $password)) {
                throw new Exception("Gagal insert user");
            }

            $iduser = $this->conn->insert_id;

            $sql = "INSERT INTO pemilik (no_wa, alamat, iduser) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $this->no_wa, $this->alamat, $iduser);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getAllPemilik()
    {
        $sql = "SELECT p.idpemilik, u.nama, u.email, p.no_wa, p.alamat
                FROM pemilik p
                INNER JOIN user u ON u.iduser = p.iduser";
        $res = $this->conn->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getPemilikById($idpemilik)
    {
        $sql = "SELECT p.idpemilik, u.nama, u.email, p.no_wa, p.alamat
                FROM pemilik p
                INNER JOIN user u ON u.iduser = p.iduser
                WHERE p.idpemilik = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idpemilik);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updatePemilik($idpemilik, $nama, $email, $no_wa, $alamat)
    {
        $this->conn->begin_transaction();
        try {
            // update user
            $sqlU = "UPDATE user u
                     INNER JOIN pemilik p ON p.iduser = u.iduser
                     SET u.nama=?, u.email=?, p.no_wa=?, p.alamat=?
                     WHERE p.idpemilik=?";
            $stmt = $this->conn->prepare($sqlU);
            $stmt->bind_param("ssssi", $nama, $email, $no_wa, $alamat, $idpemilik);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function deletePemilik($idpemilik)
    {
        // cari iduser dari pemilik
        $sql = "SELECT iduser FROM pemilik WHERE idpemilik = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idpemilik);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!$row) return false;
        $iduser = (int)$row['iduser'];

        $this->conn->begin_transaction();
        try {
            // hapus pemilik dulu
            $stmt = $this->conn->prepare("DELETE FROM pemilik WHERE idpemilik=?");
            $stmt->bind_param("i", $idpemilik);
            $stmt->execute();

            // kalau diminta sekalian hapus user
            $stmt = $this->conn->prepare("DELETE FROM user WHERE iduser=?");
            $stmt->bind_param("i", $iduser);
            $stmt->execute();


            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    // Tambahkan di class PemilikModel
public function countPetByPemilik(int $idpemilik): int {
    $sql  = "SELECT COUNT(*) AS jml FROM pet WHERE idpemilik = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $idpemilik);
    $stmt->execute();
    $jml = (int)$stmt->get_result()->fetch_assoc()['jml'];
    return $jml;
}

}
