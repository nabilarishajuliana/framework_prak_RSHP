@extends('layouts.app')
@section('title', 'Edit Pemilik & User')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Edit Pemilik & Akun User</h2>

    <form action="{{ route('admin.pemilik.update', $pemilik->idpemilik) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf @method('PUT')

        <h5 class="fw-semibold mb-3 text-primary">Data User</h5>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $pemilik->user->nama) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $pemilik->user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control" placeholder="Isi jika ingin ubah password">
        </div>

        <hr class="my-4">

        <h5 class="fw-semibold mb-3 text-primary">Data Pemilik</h5>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $pemilik->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">No. WhatsApp</label>
            <input type="text" name="no_wa" value="{{ old('no_wa', $pemilik->no_wa) }}" class="form-control" required>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.pemilik') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
</div>
@endsection
