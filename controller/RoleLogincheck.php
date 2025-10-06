<?php
class RoleLoginCheck
{
    public function __construct(string $requiredRole = null)
    {
        // Pastikan session aktif
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // 1️⃣ Cek apakah sudah login
        if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /RSH/pageCover/login.php');
            exit();
        }

        // 2️⃣ Kalau parameter role dikirim → cocokkan dengan session role
        if ($requiredRole !== null) {
            $currentRole = $_SESSION['role'] ?? null;

            // Bandingkan case-insensitive (biar 'Administrator' dan 'administrator' dianggap sama)
            if (strtolower($currentRole) !== strtolower($requiredRole)) {
                header('Location: /RSH/pageCover/login.php');
                exit();
            }
        }
    }


    // public function logout(): void
    // {
    //     session_destroy();
    //     header('Location: /RSH/pageCover/login.php');
    //     exit();
    // }
}
