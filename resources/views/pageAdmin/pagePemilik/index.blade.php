@extends('layouts.app')

@section('title', 'Data Pemilik Hewan')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Pemilik Hewan</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="#" class="btn btn-primary disabled" title="Fitur belum tersedia">
                + Tambah Pemilik
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
                            <th>NO</th>
                            <!-- <th>ID Pemilik</th> -->
                            <th>Nama Pemilik</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Jumlah Hewan</th>
                            <th>Daftar Hewan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemilik as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <!-- <td>{{ $p->idpemilik }}</td> -->
                                <td><span class="badge bg-primary">{{ $p->user->nama ?? '-' }}</span></td>
                                <td>{{ $p->alamat ?? '-' }}</td>
                                <td>{{ $p->no_wa ?? '-' }}</td>
                                <td>{{ $p->pet->count() }}</td>
                                <td>
                                    @if ($p->pet->count() > 0)
                                        <ul class="mb-0">
                                            @foreach ($p->pet as $hewan)
                                                <li>{{ $hewan->nama }} ({{ $hewan->rasHewan->nama_ras ?? '-' }})</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <em class="text-muted">Tidak ada hewan</em>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-warning disabled" title="Fitur belum tersedia">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger disabled" title="Fitur belum tersedia">Hapus</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada data pemilik hewan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="mt-3 text-muted small">
                Total Pemilik: {{ $pemilik->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
