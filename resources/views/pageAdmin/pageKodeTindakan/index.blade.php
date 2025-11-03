@extends('layouts.app')

@section('title', 'Data Kode Tindakan Terapi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Daftar Kode Tindakan Terapi</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
            <a href="{{ route('admin.kode.tindakan.create') }}" class="btn btn-primary">+ Tambah Kode Tindakan</a>
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
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Kategori Klinis</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kodeTindakan as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-primary">{{ $k->kode }}</span></td>
                            <td>{{ $k->deskripsi_tindakan_terapi }}</td>
                            <td>{{ $k->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $k->kategoriKlinis->nama_kategori_klinis ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.kode.tindakan.edit', $k->idkode_tindakan_terapi) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.kode.tindakan.destroy', $k->idkode_tindakan_terapi) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada data tindakan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
