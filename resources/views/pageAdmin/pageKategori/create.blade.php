@extends('layouts.adminlte.app')

@section('title', 'Tambah Kategori')
@section('page_title', 'Tambah Kategori')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-primary mb-0">
            <i class="bi bi-folder-plus me-2"></i>Tambah Kategori Baru
        </h5>
        <small class="text-muted">Masukkan kategori layanan baru untuk sistem.</small>
    </div>

    <div class="card-body pt-3">
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3">
                <i class="bi bi-exclamation-circle me-1"></i> Terdapat kesalahan:
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kategori.store') }}" method="POST" class="mt-2">
            @csrf
            <div class="mb-3">
                <label for="nama_kategori" class="form-label fw-semibold text-dark">Nama Kategori</label>
                <input type="text" 
                       name="nama_kategori"
                       id="nama_kategori"
                       value="{{ old('nama_kategori') }}"
                       placeholder="Contoh: Pemeriksaan Umum, Bedah Minor, Grooming..."
                       class="form-control form-control-lg border-1 rounded-3 @error('nama_kategori') is-invalid @enderror">
                @error('nama_kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.kategori') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-check2-circle"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
