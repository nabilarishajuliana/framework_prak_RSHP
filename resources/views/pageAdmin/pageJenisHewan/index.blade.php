@extends('layouts.adminlte.app')

@section('title', 'Data Jenis Hewan')
@section('page_title', 'Data Jenis Hewan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-semibold text-dark mb-0"><i class="bi bi-tag me-2 text-primary"></i>Daftar Jenis Hewan</h5>
            <small class="text-muted">Kelola data jenis hewan yang tersedia di sistem</small>
        </div>
        <a href="{{ route('admin.jenis.hewan.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Jenis
        </a>
    </div>

    <div class="card-body pt-2">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-pill px-3 py-2">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-pill px-3 py-2">
            <i class="bi bi-exclamation-circle me-1"></i> Terjadi kesalahan:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama Jenis Hewan</th>
                        <th style="width: 20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisHewan as $index => $j)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fw-semibold">
                                {{ $j->nama_jenis_hewan }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.jenis.hewan.edit', $j->idjenis_hewan) }}"
                                    class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.jenis.hewan.destroy', $j->idjenis_hewan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                        class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted text-center py-4 fst-italic">
                            Belum ada data jenis hewan yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-end text-muted small mt-3">
            Total data: <strong>{{ $jenisHewan->count() }}</strong>
        </div>
    </div>
</div>
@endsection