@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Dashboard Dokter</h2>
        <div>
            <span class="text-muted">Halo, <strong>{{ session('user_name') }}</strong> 👋</span>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Antrian Hari Ini</h6>
                    <h3 class="fw-bold text-primary">{{ $totalAntrianHariIni }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Selesai Diperiksa</h6>
                    <h3 class="fw-bold text-success">{{ $totalPasienSelesai }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Dibatalkan</h6>
                    <h3 class="fw-bold text-danger">{{ $totalBatal }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Hewan Terdaftar</h6>
                    <h3 class="fw-bold text-secondary">{{ $totalPet }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h5 class="fw-semibold mb-0 text-dark">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3 d-grid">
                    <a href="{{ route('dokter.rekammedis') }}" class="btn btn-outline-primary">
                        <i class="bi bi-journal-medical"></i> Lihat Rekam Medis
                    </a>
                </div>
                <!-- <div class="col-md-3 d-grid">
                    <a href="{{ route('dokter.dashboard') }}" class="btn btn-outline-success">
                        <i class="bi bi-clipboard2-pulse"></i> Antrian Hari Ini
                    </a>
                </div> -->
               
            </div>
        </div>
    </div>

    <!-- Daftar Antrian Hari Ini -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="fw-semibold mb-0 text-dark">Antrian Pemeriksaan Hari Ini</h5>
        </div>
        <div class="card-body">
            @if ($todayQueues->isEmpty())
                <p class="text-muted text-center mb-0">Belum ada pasien hari ini 🐾</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Urut</th>
                                <th>Nama Hewan</th>
                                <th>Pemilik</th>
                                <th>Waktu Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todayQueues as $td)
                                <tr>
                                    <td><strong>{{ $td->no_urut }}</strong></td>
                                    <td><span class="badge bg-info">{{ $td->pet->nama ?? '-' }}</span></td>
                                    <td>{{ $td->pet->pemilik->user->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($td->waktu_daftar)->format('H:i') }}</td>
                                    <td>
                                        @php
                                            $label = $td->status === 'N' ? 'Menunggu' : ($td->status === 'S' ? 'Selesai' : 'Batal');
                                            $color = $td->status === 'N' ? 'secondary' : ($td->status === 'S' ? 'success' : 'danger');
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ $label }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-muted small mt-4">
        &copy; {{ date('Y') }} Rumah Sakit Hewan | Developed by Princess Risha 👑
    </footer>
</div>
@endsection
