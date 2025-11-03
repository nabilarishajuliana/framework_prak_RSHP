@extends('layouts.app')

@section('title', 'Edit Jenis Hewan')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Edit Jenis Hewan</h2>

    <form action="{{ route('admin.jenis.hewan.update', $jenisHewan->idjenis_hewan) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_jenis_hewan" class="form-label">Nama Jenis Hewan</label>
            <input type="text" name="nama_jenis_hewan" id="nama_jenis_hewan" class="form-control @error('nama_jenis_hewan') is-invalid @enderror" value="{{ old('nama_jenis_hewan', $jenisHewan->nama_jenis_hewan) }}" required>
            @error('nama_jenis_hewan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.jenis.hewan') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
</div>
@endsection
