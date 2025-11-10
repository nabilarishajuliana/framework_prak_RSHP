@extends('layouts.app')
@section('title', 'Tambah Role')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Tambah Role Baru</h2>
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan!</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('admin.role.store') }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Role</label>
            <input type="text" name="nama_role" class="form-control @error('nama_role') is-invalid @enderror" required>
            @error('nama_role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.role') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>
@endsection