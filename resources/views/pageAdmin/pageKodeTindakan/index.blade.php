@extends('layouts.app')

@section('title', 'Data Kode Tindakan Terapi')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Kode Tindakan Terapi</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="#" class="btn btn-primary disabled" title="Fitur belum tersedia">
                + Tambah Tindakan
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
                            <!-- <th>ID</th> -->
                            <th>Kode</th>
                            <th>Nama Tindakan</th>
                            <th>Kategori</th>
                            <th>Kategori Klinis</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kodeTindakan as $index => $kt)
                            <tr>
                                 <td>{{ $index + 1 }}</td>
                                <!-- <td>{{ $kt->idkode_tindakan_terapi }}</td> -->
                                <td><span class="badge bg-primary">{{ $kt->kode }}</span></td>
                                <td>{{ $kt->deskripsi_tindakan_terapi }}</td>
                                <td>{{ $kt->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $kt->kategoriKlinis->nama_kategori_klinis ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-warning disabled" title="Fitur belum tersedia">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger disabled" title="Fitur belum tersedia">Hapus</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data kode tindakan terapi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="mt-3 text-muted small">
                Total data: {{ $kodeTindakan->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
