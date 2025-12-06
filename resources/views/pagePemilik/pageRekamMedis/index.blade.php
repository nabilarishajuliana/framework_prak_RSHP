@extends('layouts.app')
@section('title', 'Rekam Medis')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-file-medical text-success me-2"></i>Rekam Medis
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Rekam Medis</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('pemilik.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Cari Rekam Medis</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari diagnosa, nama pet...">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Filter Pet</label>
                    <select class="form-select" id="filterPet">
                        <option value="">Semua Pet</option>
                        @foreach($rekamMedis->unique('temuDokter.pet.idpet') as $rm)
                            @if($rm->temuDokter && $rm->temuDokter->pet)
                            <option value="{{ $rm->temuDokter->pet->idpet }}">
                                {{ $rm->temuDokter->pet->nama }}
                            </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Urutkan</label>
                    <select class="form-select" id="sortBy">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="applyFilter()">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1 small">Total Rekam Medis</h6>
                            <h2 class="fw-bold mb-0">{{ $rekamMedis->count() }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-file-medical fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1 small">Bulan Ini</h6>
                            <h2 class="fw-bold mb-0">
                                {{ $rekamMedis->filter(function($rm) {
                                    return $rm->created_at >= now()->startOfMonth();
                                })->count() }}
                            </h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-calendar-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1 small">Pet Terdaftar</h6>
                            <h2 class="fw-bold mb-0">
                                {{ $rekamMedis->unique('temuDokter.pet.idpet')->count() }}
                            </h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-paw fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekam Medis List -->
    @if($rekamMedis->count() > 0)
        <div class="row g-3" id="rekamMedisList">
            @foreach($rekamMedis as $rm)
            <div class="col-12" data-pet-id="{{ $rm->temuDokter->pet->idpet ?? '' }}">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Pet Info -->
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-paw text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ $rm->temuDokter->pet->nama ?? 'N/A' }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $rm->temuDokter->pet->rasHewan->nama_ras ?? 'N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Diagnosa -->
                            <div class="col-md-4">
                                <div>
                                    <small class="text-muted d-block mb-1">Diagnosa</small>
                                    <p class="mb-0 fw-semibold">
                                        {{ Str::limit($rm->diagnosa, 60) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Dokter & Tanggal -->
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-user-md me-1"></i>
                                        {{ $rm->dokterPemeriksa->user->nama ?? 'N/A' }}
                                    </small>
                                </div>
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($rm->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                                    </small>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-md-2 text-end">
                                <a href="{{ route('pemilik.rekammedis.show', $rm->idrekam_medis) }}" 
                                   class="btn btn-primary btn-sm mb-1">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                                <!-- <a href="{{ route('pemilik.rekammedis.print', $rm->idrekam_medis) }}" 
                                   class="btn btn-outline-secondary btn-sm"
                                   target="_blank">
                                    <i class="fas fa-print me-1"></i>Print
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-file-medical text-muted opacity-50" style="font-size: 5rem;"></i>
                </div>
                <h4 class="fw-bold mb-3">Belum Ada Rekam Medis</h4>
                <p class="text-muted mb-4">
                    Rekam medis akan muncul setelah pet Anda melakukan konsultasi dengan dokter
                </p>
                <a href="{{ route('pemilik.jadwal.create') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-plus me-2"></i>Buat Jadwal Konsultasi
                </a>
            </div>
        </div>
    @endif
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.15) !important;
}
</style>

<script>
function applyFilter() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const petFilter = document.getElementById('filterPet').value;
    const sortBy = document.getElementById('sortBy').value;
    
    const cards = Array.from(document.querySelectorAll('#rekamMedisList > div'));
    
    // Filter
    cards.forEach(card => {
        const petId = card.dataset.petId;
        const text = card.textContent.toLowerCase();
        
        const matchesSearch = text.includes(searchTerm);
        const matchesPet = !petFilter || petId === petFilter;
        
        if (matchesSearch && matchesPet) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
    
    // Sort (simple implementation)
    if (sortBy === 'terlama') {
        cards.reverse();
    }
    
    const container = document.getElementById('rekamMedisList');
    cards.forEach(card => container.appendChild(card));
}

// Real-time search
document.getElementById('searchInput')?.addEventListener('input', applyFilter);
</script>
@endsection