@extends('layouts.adminlte.app')

@section('title', 'Tambah Jenis Hewan')
@section('page_title', 'Tambah Jenis Hewan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-primary mb-0">
            <i class="bi bi-plus-circle me-2"></i>Tambah Jenis Hewan Baru
        </h5>
        <small class="text-muted">Masukkan nama jenis hewan yang ingin ditambahkan.</small>
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

        <form action="{{ route('admin.jenis.hewan.store') }}" method="POST" class="mt-2">
            @csrf
            <div class="mb-3">
                <label for="nama_jenis_hewan" class="form-label fw-semibold text-dark">Nama Jenis Hewan</label>
                <input type="text" 
                       name="nama_jenis_hewan"
                       id="nama_jenis_hewan"
                       value="{{ old('nama_jenis_hewan') }}"
                       placeholder="Contoh: Kucing, Anjing, Kelinci..."
                       class="form-control form-control-lg border-1 rounded-3 @error('nama_jenis_hewan') is-invalid @enderror">
                @error('nama_jenis_hewan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.jenis.hewan') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
