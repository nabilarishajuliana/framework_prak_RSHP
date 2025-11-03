@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Daftar Kategori</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $k->idkategori }}</td>
                            <td><span class="badge bg-info text-dark">{{ $k->nama_kategori }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('admin.kategori.edit', $k->idkategori) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.kategori.destroy', $k->idkategori) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
