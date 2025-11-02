@extends('layouts.app')

@section('title', 'Data Kategori Klinis')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Kategori Klinis</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
            <a href="" class="btn btn-primary">
                + Tambah Kategori Klinis
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
                            <th>Nama Kategori Klinis</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoriKlinis as $index => $kk)
                            <tr>
                                 <td>{{ $index + 1 }}</td>
                                <!-- <td>{{ $kk->idkategori_klinis }}</td> -->
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $kk->nama_kategori_klinis }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="" 
                                       class="btn btn-sm btn-warning">Edit</a>

                                    <form action="" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                                class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data kategori klinis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="mt-3 text-muted small">
                Total data: {{ $kategoriKlinis->count() }}
            </div>
        </div>
    </div>
</div>
@endsection
