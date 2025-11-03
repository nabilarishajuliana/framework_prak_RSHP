@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Edit Kategori</h2>

    <form action="{{ route('admin.kategori.update', $kategori->idkategori) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="form-control @error('nama_kategori') is-invalid @enderror" required>
            @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div> -->

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kategori') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
</div>
@endsection
