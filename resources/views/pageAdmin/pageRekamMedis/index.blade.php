@extends('layouts.adminlte.app')

@section('title', 'Manajemen Rekam Medis')

@section('content')
<div class="app-content-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-journal-medical text-primary me-2"></i>
                Manajemen Rekam Medis
            </h3>
            <p class="text-muted small mb-0">Kelola seluruh rekam medis pasien di sistem.</p>
        </div>

        <a href="{{ route('admin.rekammedis.create') }}" 
           class="btn btn-primary btn-sm rounded-pill px-3">
            <i class="bi bi-plus-circle me-1"></i> Tambah Rekam Medis
        </a>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Hewan</th>
                                <th>Pemilik</th>
                                <th>Tanggal</th>
                                <th>Dokter</th>
                                <th>Diagnosa</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($rekam as $i => $r)
                                <tr>

                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $r->reservasi?->pet?->nama ?? '-' }}</td>

                                    <td>{{ $r->reservasi?->pet?->pemilik?->user?->nama ?? '-' }}</td>

                                    <td>
                                        {{ $r->created_at ? \Carbon\Carbon::parse($r->created_at)->format('d M Y - H:i').' WIB' : '-' }}
                                    </td>

                                    <td>{{ $r->dokterPemeriksa?->user?->nama ?? '-' }}</td>

                                    <td><small>{{ Str::limit($r->diagnosa,50) }}</small></td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">

                                            <a href="{{ route('admin.rekammedis.detail', $r->idrekam_medis) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.rekammedis.edit', $r->idrekam_medis) }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('admin.rekammedis.destroy', $r->idrekam_medis) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
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
                                        <span class="fst-italic">Belum ada rekam medis.</span>
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

@endsection
