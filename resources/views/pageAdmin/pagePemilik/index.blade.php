@extends('layouts.app')
@section('title', 'Data Pemilik Hewan')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Pemilik Hewan</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
            <a href="{{ route('admin.pemilik.create') }}" class="btn btn-primary">+ Tambah Pemilik</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat</th>
                        <th>No. WhatsApp</th>
                        <th>Jumlah Hewan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemilik as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-info text-dark">{{ $p->user->nama ?? '-' }}</span></td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->no_wa }}</td>
                            <td>{{ $p->pet->count() }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pemilik.edit', $p->idpemilik) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.pemilik.destroy', $p->idpemilik) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data pemilik ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada data pemilik.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
