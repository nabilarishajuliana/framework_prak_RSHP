@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-user-circle text-info me-2"></i>Profil Saya
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </nav>
        </div>
        
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <!-- Avatar -->
                    <div class="mb-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user text-info" style="font-size: 4rem;"></i>
                        </div>
                    </div>

                    <!-- User Info -->
                    <h3 class="fw-bold mb-2">{{ $pemilik->user->nama }}</h3>
                    <p class="text-muted mb-3">
                        <i class="fas fa-envelope me-2"></i>{{ $pemilik->user->email }}
                    </p>

                    <span class="badge bg-info fs-6 px-3 py-2">
                        <i class="fas fa-id-badge me-2"></i>Pemilik Pet
                    </span>

                    <hr class="my-4">

                    <!-- Quick Stats
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <h3 class="fw-bold text-primary mb-1">
                                    {{ $pemilik->pet->count() }}
                                </h3>
                                <small class="text-muted">Total Pet</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <h3 class="fw-bold text-success mb-1">
                                    {{ $pemilik->pet->sum(function($pet) {
                                        return $pet->temuDokter->count();
                                    }) }}
                                </h3>
                                <small class="text-muted">Kunjungan</small>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Account Info -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-key text-warning me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">ID User</small>
                        <p class="mb-0 fw-semibold">{{ $pemilik->user->iduser }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">ID Pemilik</small>
                        <p class="mb-0 fw-semibold">{{ $pemilik->idpemilik }}</p>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Status Akun</small>
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="col-md-8">
            <!-- Personal Information -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user text-primary me-2"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="small text-muted mb-2">Nama Lengkap</label>
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-user text-primary me-2"></i>
                                <strong>{{ $pemilik->user->nama }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted mb-2">Email</label>
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-envelope text-info me-2"></i>
                                <strong>{{ $pemilik->user->email }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted mb-2">Nomor WhatsApp</label>
                            <div class="bg-light rounded p-3">
                                <i class="fab fa-whatsapp text-success me-2"></i>
                                <strong>{{ $pemilik->no_wa ?: '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted mb-2">ID Pemilik</label>
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-id-card text-warning me-2"></i>
                                <strong>{{ $pemilik->idpemilik }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted mb-2">Alamat</label>
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <strong>{{ $pemilik->alamat ?: 'Belum diisi' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pet Information -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-paw text-warning me-2"></i>Daftar Pet
                    </h5>
                    <a href="{{ route('pemilik.pet.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($pemilik->pet->count() > 0)
                        <div class="row g-3">
                            @foreach($pemilik->pet->take(4) as $pet)
                            <div class="col-md-6">
                                <div class="card border h-100 hover-card">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-paw text-warning fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1">{{ $pet->nama }}</h6>
                                                <small class="text-muted">{{ $pet->rasHewan->nama_ras ?? 'N/A' }}</small>
                                            </div>
                                            <a href="{{ route('pemilik.pet.show', $pet->idpet) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-paw text-muted fs-1 mb-3 d-block opacity-50"></i>
                            <p class="text-muted mb-3">Belum ada pet terdaftar</p>
                            <a href="{{ route('pemilik.pet.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Pet
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Summary -->
            <!-- <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-success me-2"></i>Ringkasan Aktivitas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                <h3 class="fw-bold text-primary mb-1">
                                    {{ $pemilik->pet->count() }}
                                </h3>
                                <small class="text-muted">Pet Terdaftar</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                <h3 class="fw-bold text-info mb-1">
                                    {{ $pemilik->pet->sum(function($pet) {
                                        return $pet->temuDokter->where('status', 'N')->count();
                                    }) }}
                                </h3>
                                <small class="text-muted">Jadwal Aktif</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                <h3 class="fw-bold text-success mb-1">
                                    {{ $pemilik->pet->sum(function($pet) {
                                        return $pet->temuDokter->where('status', 'S')->count();
                                    }) }}
                                </h3>
                                <small class="text-muted">Kunjungan Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15) !important;
}
</style>
@endsection