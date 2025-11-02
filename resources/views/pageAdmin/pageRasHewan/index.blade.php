@extends('layouts.app')

@section('title', 'Data Ras Hewan')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Ras Hewan</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="#" class="btn btn-primary disabled" title="Fitur belum tersedia">
                + Tambah Ras
            </a>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <!-- <th>ID Ras</th> -->
                            <th>Nama Ras</th>
                            <th>Jenis Hewan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rasHewan as $index => $r)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <!-- <td>{{ $r->idras_hewan }}</td> -->
                                <td><span class="badge bg-primary">{{ $r->nama_ras }}</span></td>
                                <td>{{ $r->jenisHewan->nama_jenis_hewan ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-warning disabled" title="Fitur belum tersedia">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger disabled" title="Fitur belum tersedia">Hapus</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data ras hewan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="mt-3 text-muted small">
                Total data: {{ $rasHewan->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
