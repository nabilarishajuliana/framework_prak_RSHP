@extends('layouts.app')

@section('title', 'Dashboard Resepsionis')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Dashboard Resepsionis</h2>
        <div>
            <span class="text-muted">Halo, <strong>{{ session('user_name') }}</strong> 👋</span>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Pemilik</h6>
                    <h3 class="fw-bold text-primary">{{ $totalPemilik }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Hewan Pasien</h6>
                    <h3 class="fw-bold text-success">{{ $totalPet }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-semibold text-dark">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6 d-grid">
                    <a href="{{ route('resepsionis.pemilik') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-circle"></i> Kelola Data Pemilik
                    </a>
                </div>
                <div class="col-md-6 d-grid">
                    <a href="{{ route('resepsionis.pet') }}" class="btn btn-outline-success">
                        <i class="bi bi-bug"></i> Kelola Data Hewan
                    </a>
                </div>
                <div class="col-md-6 d-grid">
                    <a href="{{ route('resepsionis.temu.dokter') }}" class="btn btn-outline-success">
                        <i class="bi bi-bug"></i> Temu dokter
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted small mt-4">
        &copy; {{ date('Y') }} Rumah Sakit Hewan | Developed by Princess Risha 👑
    </footer>
</div>
@endsection
