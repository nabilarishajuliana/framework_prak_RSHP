@extends('layouts.adminlte.app')

@section('title', 'Rekam Medis')

@section('content')
<div class="app-content-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-journal-medical text-primary me-2"></i>
                Rekam Medis
            </h3>
            <p class="text-muted small mb-0">Daftar semua rekam medis hewan.</p>
        </div>

        <a href="{{ route('perawat.rekammedis.create') }}" 
           class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-plus-circle me-1"></i> Tambah Rekam Medis
        </a>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Hewan</th>
                                <th width="15%">Pemilik</th>
                                <th width="13%">Tanggal</th>
                                <th width="15%">Dokter</th>
                                <th width="20%">Diagnosa</th>
                                <th width="17%" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($rekam as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                {{-- Kolom Hewan --}}
                                <td>
                                    @if ($r->reservasi && $r->reservasi->pet)
                                        <strong>{{ $r->reservasi->pet->nama }}</strong>
                                        @if($r->reservasi->pet->deleted_at)
                                            <br><span class="badge bg-danger badge-sm">Pet Dihapus</span>
                                        @endif
                                    @elseif($r->reservasi)
                                        <span class="text-muted fst-italic">Pet tidak ditemukan</span>
                                    @else
                                        <span class="text-muted fst-italic">Reservasi dihapus</span>
                                    @endif
                                </td>

                                {{-- Kolom Pemilik --}}
                                <td>
                                    @if($r->reservasi && $r->reservasi->pet && $r->reservasi->pet->pemilik)
                                        {{ $r->reservasi->pet->pemilik->user->nama ?? '-' }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- Kolom Tanggal --}}
                                <td>
                                    @if($r->created_at)
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}<br>
                                            {{ \Carbon\Carbon::parse($r->created_at)->format('H:i') }} WIB
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- Kolom Dokter --}}
                                <td>
                                    @if($r->dokterPemeriksa && $r->dokterPemeriksa->user)
                                        <small>{{ $r->dokterPemeriksa->user->nama }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- Kolom Diagnosa --}}
                                <td>
                                    <small>{{ Str::limit($r->diagnosa, 50) }}</small>
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        {{-- Detail --}}
                                        <a href="{{ route('perawat.rekammedis.detail', $r->idrekam_medis) }}"
                                           class="btn btn-info btn-sm" 
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('perawat.rekammedis.edit', $r->idrekam_medis) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('perawat.rekammedis.destroy', $r->idrekam_medis) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus rekam medis ini? Data detail rekam medis juga akan ikut terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                    <span class="fst-italic">Belum ada data rekam medis.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    // Auto dismiss alerts after 3 seconds
    setTimeout(() => {
        document.querySelectorAll('.auto-dismiss').forEach(el => {
            let alert = new bootstrap.Alert(el);
            alert.close();
        });
    }, 3000);
</script>

@endsection