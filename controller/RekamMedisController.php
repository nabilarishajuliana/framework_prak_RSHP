<?php
require_once 'C:/xampp/htdocs/RSH/model/RekamMedisModel.php';
require_once 'C:/xampp/htdocs/RSH/model/DetailRekamMedisModel.php';
require_once 'C:/xampp/htdocs/RSH/model/KodeTindakanModel.php';
require_once 'C:/xampp/htdocs/RSH/model/UserModel.php'; // <-- tambahkan ini


if (session_status() === PHP_SESSION_NONE) session_start();

class RekamMedisController
{
    private $rekamModel;
    private $detailModel;
    private $kodeModel;
    private $userModel; // <-- tambahkan


    public function __construct()
    {
        $this->rekamModel  = new RekamMedisModel();
        $this->detailModel = new DetailRekamMedisModel();
        $this->kodeModel   = new KodeTindakanTerapiModel();
        $this->userModel   = new userModel(); // <-- tambahkan
    }

    /* ===== Rekam Medis (header) ===== */
    public function index()
    {
        return $this->rekamModel->getAll();
    }
    public function get($id)
    {
        return $this->rekamModel->getById((int)$id);
    }

    public function listDokter(): array
    {        // <-- tambahkan
        return $this->userModel->getDoctors();
    }

    public function getDetailByRekam(int $idrekam): array
{
    return $this->detailModel->getByRekam($idrekam);
}


    // dropdown: temu_dokter hari ini yang belum punya rekam
    public function listTemuDokter()
    {
        return $this->rekamModel->listTemuDokterUntukRekam();
    }

    // public function create($post)
    // {
    //     $idReservasi = (int)($post['idreservasi_dokter'] ?? 0);
    //     $anamnesa    = trim($post['anamnesa'] ?? '');
    //     $temuan      = trim($post['temuan_klinis'] ?? '');
    //     $diagnosa    = trim($post['diagnosa'] ?? '');
    //     $dokter = (int)($post['dokter_pemeriksa'] ?? 0);

    //     if ($dokter <= 0) {
    //         $_SESSION['error'] = 'Pilih Dokter Pemeriksa.';
    //         return false;
    //     }

    //     if ($idReservasi <= 0 || $anamnesa === '' || $diagnosa === '') {
    //         $_SESSION['error'] = 'Anamnesa & diagnosa wajib diisi.';
    //         return false;
    //     }
    //     $ok = $this->rekamModel->create($idReservasi, $anamnesa, $temuan, $diagnosa, $dokter);
    //     $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Rekam medis berhasil dibuat.' : 'Gagal membuat rekam medis.';
    //     return $ok;
    // }

    public function create($post)
    {
        $idReservasi = (int)($post['idreservasi_dokter'] ?? 0);
        $anamnesa    = trim($post['anamnesa'] ?? '');
        $temuan      = trim($post['temuan_klinis'] ?? '');
        $diagnosa    = trim($post['diagnosa'] ?? '');
        $dokter      = (int)($post['dokter_pemeriksa'] ?? 0); // WAJIB

        if ($idReservasi <= 0 || $dokter <= 0) {
            $_SESSION['error'] = 'Pilih Temu Dokter dan Dokter Pemeriksa.';
            return false;
        }
        if ($anamnesa === '' || $diagnosa === '') {
            $_SESSION['error'] = 'Anamnesa & Diagnosa wajib diisi.';
            return false;
        }

        // 1) buat header, dapatkan ID
        $newId = $this->rekamModel->create($idReservasi, $anamnesa, $temuan, $diagnosa, $dokter);
        if (!$newId) {
            $_SESSION['error'] = 'Gagal membuat rekam medis.';
            return false;
        }

        // 2) detail (boleh banyak baris)
        $codes  = $post['idkode_tindakan_terapi'] ?? [];
        $notes  = $post['detail'] ?? [];

        // pastikan bentuk array
        if (!is_array($codes)) $codes = [$codes];
        if (!is_array($notes)) $notes = [$notes];

        $added = 0;
        $n = max(count($codes), count($notes));
        for ($i = 0; $i < $n; $i++) {
            $idkode = (int)($codes[$i] ?? 0);
            $text   = trim((string)($notes[$i] ?? ''));
            if ($idkode > 0 && $text !== '') {
                if ($this->detailModel->create($newId, $idkode, $text)) $added++;
            }
        }

        $_SESSION['message'] = 'Rekam medis dibuat. Detail tersimpan: ' . $added . ' baris.';
        return $newId; // penting: biar view bisa redirect ke halaman kelola
    }


    public function update($id, $post)
    {
        $anamnesa = trim($post['anamnesa'] ?? '');
        $temuan   = trim($post['temuan_klinis'] ?? '');
        $diagnosa = trim($post['diagnosa'] ?? '');
        $dokter = ($post['dokter_pemeriksa'] ?? '') === '' ? null : (int)$post['dokter_pemeriksa'];

        if ($anamnesa === '' || $diagnosa === '') {
            $_SESSION['error'] = 'Anamnesa & diagnosa wajib diisi.';
            return false;
        }
        $ok = $this->rekamModel->update((int)$id, $anamnesa, $temuan, $diagnosa, $dokter);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Rekam medis diperbarui.' : 'Gagal memperbarui rekam medis.';
        return $ok;
    }

    public function delete($id)
    {
        $ok = $this->rekamModel->delete((int)$id);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Rekam medis dihapus.' : 'Gagal menghapus.';
        // kembali ke halaman sebelumnya / default ke perawat
        $back = $_SERVER['HTTP_REFERER'] ?? '/rsh/pagePerawat/pageRekamMedis/readRekamMedis.php';
        header("Location: " . $back);
        exit();
    }

    /* ===== Detail tindakan/terapi ===== */
    public function details($idrekam)
    {
        return $this->detailModel->getByRekam((int)$idrekam);
    }
    public function listKode()
    {
        return $this->kodeModel->getAll();
    }

    public function addDetail($idrekam, $post)
    {
        $idkode = (int)($post['idkode_tindakan_terapi'] ?? 0);
        $detail = trim($post['detail'] ?? '');
        if ($idkode <= 0) {
            $_SESSION['error'] = 'Pilih kode tindakan/terapi.';
            return false;
        }
        if ($detail === '') {
            $_SESSION['error'] = 'Isikan catatan detail tindakan.';
            return false;
        }

        $ok = $this->detailModel->create((int)$idrekam, $idkode, $detail);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Detail tindakan ditambahkan.' : 'Gagal menambahkan detail.';
        return $ok;
    }

    public function getDetail($iddetail)
    {
        return $this->detailModel->getOne((int)$iddetail);
    }

    public function updateDetail($iddetail, $post)
    {
        $idkode = (int)($post['idkode_tindakan_terapi'] ?? 0);
        $detail = trim($post['detail'] ?? '');
        if ($idkode <= 0 || $detail === '') {
            $_SESSION['error'] = 'Lengkapi data detail.';
            return false;
        }

        $ok = $this->detailModel->update((int)$iddetail, $idkode, $detail);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Detail tindakan diperbarui.' : 'Gagal memperbarui detail.';
        return $ok;
    }

    public function deleteDetail($iddetail)
    {
        $ok = $this->detailModel->delete((int)$iddetail);
        $_SESSION[$ok ? 'message' : 'error'] = $ok ? 'Detail tindakan dihapus.' : 'Gagal menghapus detail.';
        return $ok;
    }

    public function getByPet(int $idpet): array
{
    return $this->rekamModel->getByPet($idpet);
}
}
