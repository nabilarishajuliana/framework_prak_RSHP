@extends('layouts.adminlte.app')

@section('title', 'Edit Jenis Hewan')
@section('page_title', 'Edit Jenis Hewan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-warning mb-0">
            <i class="bi bi-pencil-square me-2"></i>Edit Jenis Hewan
        </h5>
        <small class="text-muted">Perbarui informasi jenis hewan yang sudah ada.</small>
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

        <form action="{{ route('admin.jenis.hewan.update', $jenisHewan->idjenis_hewan) }}" method="POST" class="mt-2">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_jenis_hewan" class="form-label fw-semibold text-dark">Nama Jenis Hewan</label>
                <input type="text" 
                       name="nama_jenis_hewan"
                       id="nama_jenis_hewan"
                       value="{{ old('nama_jenis_hewan', $jenisHewan->nama_jenis_hewan) }}"
                       class="form-control form-control-lg border-1 rounded-3 @error('nama_jenis_hewan') is-invalid @enderror"
                       required>
                @error('nama_jenis_hewan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.jenis.hewan') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-warning text-dark rounded-pill px-4">
                    <i class="bi bi-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
