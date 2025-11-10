@extends('layouts.app')
@section('title', 'Tambah Pemilik Baru')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Tambah Pemilik Baru</h2>

    {{-- 🔴 Pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <script>window.scrollTo({ top: 0, behavior: 'smooth' });</script>
    @endif

    <form action="{{ route('admin.pemilik.store') }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf

        <h5 class="fw-semibold mb-3 text-primary">Data User</h5>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <hr class="my-4">

        <h5 class="fw-semibold mb-3 text-primary">Data Pemilik</h5>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat') }}</textarea>
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No. WhatsApp</label>
            <input type="text" name="no_wa" value="{{ old('no_wa') }}" class="form-control @error('no_wa') is-invalid @enderror">
            @error('no_wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.pemilik') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>
@endsection
