@extends('layouts.app')

@section('title', 'Data Jenis Hewan')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Daftar Jenis Hewan</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="{{ route('admin.jenis.hewan.create') }}" class="btn btn-primary">
                + Tambah Jenis
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
                            <th>Nama Jenis Hewan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jenisHewan as $index => $j)
                            <tr>
                                 <td>{{ $index + 1 }}</td>
                                <!-- <td>{{ $j->idjenis_hewan }}</td> -->
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $j->nama_jenis_hewan }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.jenis.hewan.edit', $j->idjenis_hewan) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.jenis.hewan.destroy', $j->idjenis_hewan) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data jenis hewan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 text-muted small">
                Total data: {{ $jenisHewan->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
