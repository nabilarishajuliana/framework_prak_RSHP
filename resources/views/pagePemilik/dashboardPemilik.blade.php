@extends('layouts.app')
@section('title', 'Dashboard Pemilik')
@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard Pemilik</h2>
            <p class="text-muted mb-0">Selamat datang di sistem manajemen pet</p>
        </div>
        <div class="text-end">
            <span class="text-muted">Halo, <strong>{{ $pemilik->user->nama ?? session('user_name') }}</strong> 👋</span>
            <br>
            <small class="text-muted">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</small>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Pet Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-4">
                                <i class="fas fa-paw text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Total Pet</h6>
                            <h1 class="fw-bold mb-0 display-4">{{ $totalPets }}</h1>
                            <small class="text-success mt-2 d-inline-block">
                                <i class="fas fa-check-circle"></i> Pet terdaftar
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Temu Dokter Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-3 p-4">
                                <i class="fas fa-calendar-check text-info" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Total Temu Dokter</h6>
                            <h1 class="fw-bold mb-0 display-4">{{ $totalTemuDokter }}</h1>
                            <small class="text-info mt-2 d-inline-block">
                                <i class="fas fa-history"></i> Riwayat janji temu
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Menu -->
    <div class="mb-4">
        <h5 class="fw-bold mb-3">
            <i class="fas fa-bolt text-warning me-2"></i>Quick Access
        </h5>
        <div class="row g-3">
            <!-- Data Pet -->
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('pemilik.pet.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 quick-access-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="icon-wrapper bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-paw text-warning fs-2"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-2">Data Pet</h6>
                            <p class="text-muted small mb-0">Kelola informasi pet Anda</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Jadwal Temu Dokter -->
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('pemilik.jadwal.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 quick-access-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-calendar-alt text-primary fs-2"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-2">Jadwal Temu Dokter</h6>
                            <p class="text-muted small mb-0">Lihat dan kelola jadwal konsultasi</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Rekam Medis -->
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('pemilik.rekammedis.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 quick-access-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-file-medical text-success fs-2"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-2">Rekam Medis</h6>
                            <p class="text-muted small mb-0">Riwayat kesehatan pet Anda</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Profil -->
            <div class="col-md-3 col-sm-6">
                <a href="{{ route('pemilik.profile.index') }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 quick-access-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="icon-wrapper bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="fas fa-user-circle text-info fs-2"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-2">Profil Saya</h6>
                            <p class="text-muted small mb-0">Kelola data pribadi Anda</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    
    <!-- Empty State (jika tidak ada pet) -->
    @if($totalPets == 0)
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-paw text-muted opacity-50" style="font-size: 5rem;"></i>
            </div>
            <h4 class="fw-bold mb-3">Belum Ada Pet Terdaftar</h4>
        </div>
    </div>
    @endif
</div>

<style>
/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

/* Card Hover Effect */
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
}

/* Quick Access Card Hover */
.quick-access-card {
    transition: all 0.3s ease;
    cursor: pointer;
}
.quick-access-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.2) !important;
}
.quick-access-card:hover .icon-wrapper {
    transform: scale(1.1);
}

.icon-wrapper {
    transition: transform 0.3s ease;
}

/* Display Number Animation */
.display-4 {
    font-size: 3.5rem;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2.5rem;
    }
}
</style>
@endsection