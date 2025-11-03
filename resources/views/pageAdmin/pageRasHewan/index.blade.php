@extends('layouts.app')

@section('title', 'Data Ras Hewan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Daftar Ras Hewan</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
            <a href="{{ route('admin.ras.hewan.create') }}" class="btn btn-primary">+ Tambah Ras</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table align-middle table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <!-- <th>ID</th> -->
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
                            <td><span class="badge bg-info text-dark">{{ $r->nama_ras }}</span></td>
                            <td>{{ $r->jenisHewan->nama_jenis_hewan ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.ras.hewan.edit', $r->idras_hewan) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.ras.hewan.destroy', $r->idras_hewan) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                </form>
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
    </div>
</div>
@endsection
