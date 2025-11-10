@extends('layouts.adminlte.app')

@section('title', 'Data Kode Tindakan Terapi')
@section('page_title', 'Data Kode Tindakan Terapi')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-semibold text-dark mb-0">
                <i class="bi bi-clipboard2-pulse me-2 text-primary"></i>Daftar Kode Tindakan Terapi
            </h5>
            <small class="text-muted">Kelola kode tindakan terapi yang digunakan pada rekam medis</small>
        </div>
        <a href="{{ route('admin.kode.tindakan.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kode Tindakan
        </a>
    </div>

    <div class="card-body pt-2">

        {{-- ✅ Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-pill px-3 py-2 auto-dismiss">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ✅ Error Message --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 px-3 py-2 auto-dismiss">
                <i class="bi bi-exclamation-triangle me-1"></i> Terdapat kesalahan:
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive mt-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Kategori Klinis</th>
                        <th style="width:18%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kodeTindakan as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $k->kode }}</span></td>
                            <td>{{ $k->deskripsi_tindakan_terapi }}</td>
                            <td>{{ $k->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $k->kategoriKlinis->nama_kategori_klinis ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.kode.tindakan.edit', $k->idkode_tindakan_terapi) }}" 
                                       class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.kode.tindakan.destroy', $k->idkode_tindakan_terapi) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted fst-italic py-4">Belum ada data tindakan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-end text-muted small mt-3">
            Total data: <strong>{{ $kodeTindakan->count() }}</strong>
        </div>
    </div>
</div>
@endsection
