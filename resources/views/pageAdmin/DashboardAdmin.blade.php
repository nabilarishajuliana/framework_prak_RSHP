@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Dashboard Administrator</h2>
        <div>
            <span class="text-muted">Halo, <strong>{{ session('user_name') }}</strong> 👋</span>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Users</h6>
                    <h3 class="fw-bold text-primary">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Pets</h6>
                    <h3 class="fw-bold text-success">{{ $totalPets }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Roles</h6>
                    <h3 class="fw-bold text-warning">{{ $totalRoles }}</h3>
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
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.user') }}" class="btn btn-outline-primary">
                        <i class="bi bi-people"></i> Manage Users
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.role') }}" class="btn btn-outline-warning text-dark">
                        <i class="bi bi-shield-lock"></i> Manage Roles
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.pemilik') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-person"></i> Manage Pemilik
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.pet') }}" class="btn btn-outline-success">
                        <i class="bi bi-bug"></i> Manage Pets
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.jenis.hewan') }}" class="btn btn-outline-info">
                        <i class="bi bi-tag"></i> Jenis Hewan
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.ras.hewan') }}" class="btn btn-outline-info">
                        <i class="bi bi-tags"></i> Ras Hewan
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.kategori') }}" class="btn btn-outline-dark">
                        <i class="bi bi-folder"></i> Kategori
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.kategori.klinis') }}" class="btn btn-outline-dark">
                        <i class="bi bi-journal-medical"></i> Kategori Klinis
                    </a>
                </div>
                <div class="col-md-3 d-grid">
                    <a href="{{ route('admin.kode.tindakan') }}" class="btn btn-outline-danger">
                        <i class="bi bi-clipboard2-pulse"></i> Kode Tindakan
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
