@extends('layouts.app')

@section('title', 'Dashboard Perawat')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Dashboard Perawat</h2>
        <div>
            <span class="text-muted">Halo, <strong>{{ session('user_name') }}</strong> 👋</span>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total Rekam Medis</h6>
                    <h3 class="fw-bold text-primary">{{ $totalRekamMedis }}</h3>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total Temu Dokter</h6>
                    <h3 class="fw-bold text-warning">{{ $totalTemuDokter }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-semibold text-dark">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('perawat.rekammedis') }}" class="btn btn-outline-primary">
                    <i class="bi bi-journal-medical"></i> Kelola Rekam Medis
                </a>
               
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted small mt-4">
        &copy; {{ date('Y') }} Rumah Sakit Hewan | Developed by Princess Risha 👑
    </footer>
</div>
@endsection
