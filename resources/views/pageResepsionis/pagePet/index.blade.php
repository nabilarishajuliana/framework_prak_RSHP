@extends('layouts.app')

@section('title', 'Data Hewan Pasien')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Hewan Pasien</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('resepsionis.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="#" class="btn btn-primary disabled" title="Fitur belum tersedia">
                + Tambah Hewan
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
                            <!-- <th>ID Hewan</th> -->
                            <th>Nama Hewan</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Ras Hewan</th>
                            <th>Pemilik</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pet as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <!-- <td>{{ $p->idpet }}</td> -->
                                <td><span class="badge bg-primary">{{ $p->nama }}</span></td>
                                <td>{{ $p->tanggal_lahir ?? '-' }}</td>
                                <td>{{ ucfirst($p->jenis_kelamin) ?? '-' }}</td>
                                <td>{{ $p->rasHewan->nama_ras ?? '-' }}</td>
                                <td>{{ $p->pemilik->user->nama ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-warning disabled" title="Fitur belum tersedia">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger disabled" title="Fitur belum tersedia">Hapus</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada data hewan pasien.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="mt-3 text-muted small">
                Total data: {{ $pet->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
