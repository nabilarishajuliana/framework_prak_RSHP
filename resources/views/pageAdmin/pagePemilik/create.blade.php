@extends('layouts.adminlte.app')

@section('title', 'Tambah Pemilik Baru')
@section('page_title', 'Tambah Pemilik Baru')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-primary mb-0">
            <i class="bi bi-person-plus me-2"></i>Tambah Pemilik & Akun User
        </h5>
        <small class="text-muted">Lengkapi data user dan pemilik hewan.</small>
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

        <form action="{{ route('admin.pemilik.store') }}" method="POST" class="mt-2">
            @csrf

            <h5 class="fw-semibold mb-3 text-primary"><i class="bi bi-person-lines-fill me-1"></i>Data User</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-control form-control-lg rounded-3 @error('nama') is-invalid @enderror">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Password</label>
                <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr class="my-4">

            <h5 class="fw-semibold mb-3 text-primary"><i class="bi bi-house-heart me-1"></i>Data Pemilik</h5>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Alamat</label>
                <textarea name="alamat" class="form-control rounded-3 @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat') }}</textarea>
                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">No. WhatsApp</label>
                <input type="text" name="no_wa" value="{{ old('no_wa') }}" class="form-control rounded-3 @error('no_wa') is-invalid @enderror">
                @error('no_wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.pemilik') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="bi bi-check2-circle"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
