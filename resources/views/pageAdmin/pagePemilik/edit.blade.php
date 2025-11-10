@extends('layouts.adminlte.app')

@section('title', 'Edit Pemilik & User')
@section('page_title', 'Edit Pemilik & User')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-warning mb-0">
            <i class="bi bi-pencil-square me-2"></i>Edit Data Pemilik & Akun User
        </h5>
        <small class="text-muted">Perbarui data pemilik beserta akun user-nya.</small>
    </div>

    <div class="card-body pt-3">
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 auto-dismiss">
                <i class="bi bi-exclamation-circle me-1"></i> Terdapat kesalahan:
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pemilik.update', $pemilik->idpemilik) }}" method="POST">
            @csrf @method('PUT')

            <h5 class="fw-semibold mb-3 text-primary"><i class="bi bi-person-lines-fill me-1"></i>Data User</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $pemilik->user->nama) }}" class="form-control rounded-3">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Email</label>
                    <input type="email" name="email" value="{{ old('email', $pemilik->user->email) }}" class="form-control rounded-3">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control rounded-3" placeholder="Isi jika ingin ubah password">
            </div>

            <hr class="my-4">

            <h5 class="fw-semibold mb-3 text-primary"><i class="bi bi-house-heart me-1"></i>Data Pemilik</h5>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Alamat</label>
                <textarea name="alamat" class="form-control rounded-3" rows="2">{{ old('alamat', $pemilik->alamat) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">No. WhatsApp</label>
                <input type="text" name="no_wa" value="{{ old('no_wa', $pemilik->no_wa) }}" class="form-control rounded-3">
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.pemilik') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
