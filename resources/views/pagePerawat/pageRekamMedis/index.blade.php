@extends('layouts.app')

@section('title', 'Data Rekam Medis - Perawat')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Rekam Medis</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('perawat.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
            <a href="#" class="btn btn-primary disabled" title="Fitur tambah akan datang">+ Tambah Rekam Medis</a>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>No. Urut</th>
                            <th>Waktu Daftar</th>
                            <th>Nama Hewan</th>
                            <th>Pemilik</th>
                            <th>Dokter Pemeriksa</th>
                            <th>Diagnosa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekamMedis as $rm)
                            <tr>
                                <td>{{ $rm->idrekam_medis }}</td>
                                <td>#{{ $rm->temuDokter->no_urut ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($rm->temuDokter->waktu_daftar)->format('d M Y H:i') }}</td>
                                <td><span class="badge bg-info">{{ $rm->temuDokter->pet->nama ?? '-' }}</span></td>
                                <td>{{ $rm->temuDokter->pet->pemilik->user->nama ?? '-' }}</td>
                                <td>{{ $rm->dokter->user->nama ?? '-' }}</td>
                                <td>{{ $rm->diagnosa }}</td>
                                <td class="text-center">
                                    <a href="{{ route('perawat.rekammedis.detail', $rm->idrekam_medis) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data rekam medis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 small text-muted">
                Total Data: {{ $rekamMedis->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
