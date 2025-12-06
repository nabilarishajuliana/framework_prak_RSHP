@extends('layouts.app')
@section('title', 'Data Pet')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-paw text-warning me-2"></i>Data Pet Saya
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pet</li>
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

    <!-- Filter & Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Cari Pet</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari nama pet atau ras...">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Jenis Kelamin</label>
                    <select class="form-select" id="filterGender">
                        <option value="">Semua</option>
                        <option value="L">Jantan</option>
                        <option value="P">Betina</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="applyFilter()">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pet Statistics -->
    <div class="row g-3 mb-">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 small mb-1">Total Pet</h6>
                            <h2 class="fw-bold mb-0">{{ $pets->count() }}</h2>
                        </div>
                        <i class="fas fa-paw fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 small mb-1">Jantan</h6>
                            <h2 class="fw-bold mb-0">{{ $pets->where('jenis_kelamin', 'L')->count() }}</h2>
                        </div>
                        <i class="fas fa-mars fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 small mb-1">Betina</h6>
                            <h2 class="fw-bold mb-0">{{ $pets->where('jenis_kelamin', 'P')->count() }}</h2>
                        </div>
                        <i class="fas fa-venus fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 small mb-1">Ras Berbeda</h6>
                            <h2 class="fw-bold mb-0">{{ $pets->unique('idras_hewan')->count() }}</h2>
                        </div>
                        <i class="fas fa-list fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Pet List -->
    @if($pets->count() > 0)
        <div class="row g-3" id="petList">
            @foreach($pets as $pet)
            <div class="col-md-6 col-lg-4 pet-card-wrapper" 
                 data-name="{{ strtolower($pet->nama) }}" 
                 data-ras="{{ strtolower($pet->rasHewan->nama_ras ?? '') }}"
                 data-gender="{{ $pet->jenis_kelamin }}">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body p-4">
                        <!-- Header Card -->
                        <div class="text-center mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-paw text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $pet->nama }}</h4>
                            <p class="text-muted small mb-2">{{ $pet->rasHewan->nama_ras ?? 'N/A' }}</p>
                            
                            @if($pet->jenis_kelamin == 'L')
                                <span class="badge bg-primary">
                                    <i class="fas fa-mars me-1"></i>Jantan
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-venus me-1"></i>Betina
                                </span>
                            @endif
                        </div>

                        <hr>

                        <!-- Pet Info -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Tgl Lahir</small>
                                <small class="fw-semibold">{{ $pet->tanggal_lahir }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Umur</small>
                                <small class="fw-semibold">{{ $pet->umur_text }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Warna</small>
                                <small class="fw-semibold">{{ $pet->warna_tanda }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Jenis</small>
                                <small class="fw-semibold">{{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</small>
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
                    <i class="fas fa-paw text-muted opacity-50" style="font-size: 5rem;"></i>
                </div>
                <h4 class="fw-bold mb-3">Belum Ada Pet Terdaftar</h4>
                <p class="text-muted mb-4">
                    Daftarkan pet Anda untuk mulai menggunakan layanan kami
                </p>
                <a href="{{ route('pemilik.pet.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Pet Pertama
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pet <strong id="petName"></strong>?</p>
                <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 1rem 2rem rgba(0,0,0,.15) !important;
}
</style>

<script>
function applyFilter() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const genderFilter = document.getElementById('filterGender').value;
    
    const cards = document.querySelectorAll('.pet-card-wrapper');
    
    cards.forEach(card => {
        const name = card.dataset.name;
        const ras = card.dataset.ras;
        const gender = card.dataset.gender;
        
        const matchesSearch = name.includes(searchTerm) || ras.includes(searchTerm);
        const matchesGender = !genderFilter || gender === genderFilter;
        
        if (matchesSearch && matchesGender) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

function confirmDelete(id, name) {
    document.getElementById('petName').textContent = name;
    const form = document.getElementById('deleteForm');
    form.action = `/pemilik/pet/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Real-time search
document.getElementById('searchInput')?.addEventListener('input', applyFilter);
</script>
@endsection