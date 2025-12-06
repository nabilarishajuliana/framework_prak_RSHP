@extends('layouts.app')
@section('title', 'Jadwal Temu Dokter')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-calendar-alt text-primary me-2"></i>Jadwal Temu Dokter
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Jadwal</li>
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

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-4" id="statusTabs" role="tablist">
        <li class="nav-item" role="presentation">
    <button class="nav-link active" id="today-tab" data-bs-toggle="pill" data-bs-target="#today" type="button">
        <i class="fas fa-calendar-day me-2"></i>Hari Ini 
        ({{ $jadwalTemuDokter->where('waktu_daftar', '>=', \Carbon\Carbon::today())->count() }})
    </button>
</li>

        <li class="nav-item" role="presentation">
            <button class="nav-link " id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button">
                <i class="fas fa-list me-2"></i>Semua ({{ $jadwalTemuDokter->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="belum-tab" data-bs-toggle="pill" data-bs-target="#belum" type="button">
                <i class="fas fa-clock me-2"></i>Belum Diperiksa ({{ $jadwalTemuDokter->where('status', 'N')->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="selesai-tab" data-bs-toggle="pill" data-bs-target="#selesai" type="button">
                <i class="fas fa-check-circle me-2"></i>Selesai ({{ $jadwalTemuDokter->where('status', 'S')->count() }})
            </button>
        </li>
        

    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="statusTabsContent">
        <!-- Hari Ini -->
<div class="tab-pane fade show active" id="today" role="tabpanel">
    @include('pagePemilik.pageJadwal.partials.jadwal-list', [
        'jadwals' => $jadwalTemuDokter->filter(function($j){
            return \Carbon\Carbon::parse($j->waktu_daftar)->isToday();
        })
    ])
</div>

        <!-- All -->
        <div class="tab-pane fade " id="all" role="tabpanel">
            @include('pagePemilik.pageJadwal.partials.jadwal-list', ['jadwals' => $jadwalTemuDokter])
        </div>

        <!-- Belum Diperiksa -->
        <div class="tab-pane fade" id="belum" role="tabpanel">
            @include('pagePemilik.pageJadwal.partials.jadwal-list', ['jadwals' => $jadwalTemuDokter->where('status', 'N')])
        </div>

        <!-- Selesai -->
        <div class="tab-pane fade" id="selesai" role="tabpanel">
            @include('pagePemilik.pageJadwal.partials.jadwal-list', ['jadwals' => $jadwalTemuDokter->where('status', 'S')])
        </div>

        
    </div>
</div>

<!-- Modal Konfirmasi Batal -->
<div class="modal fade" id="batalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Pembatalan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan jadwal temu dokter ini?</p>
                <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <form id="batalForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmBatal(id) {
    const form = document.getElementById('batalForm');
    form.action = `/pemilik/jadwal/${id}`;
    new bootstrap.Modal(document.getElementById('batalModal')).show();
}
</script>
@endsection