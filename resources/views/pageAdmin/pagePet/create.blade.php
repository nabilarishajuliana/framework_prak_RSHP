@extends('layouts.adminlte.app')

@section('title', 'Tambah Hewan')
@section('page_title', 'Tambah Hewan Baru')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-success mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Hewan Baru</h5>
        <small class="text-muted">Isi data hewan dengan lengkap dan benar</small>
    </div>

    <div class="card-body pt-3">
        <form action="{{ route('admin.pet.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Hewan</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="jantan">Jantan</option>
                        <option value="betina">Betina</option>
                    </select>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold text-dark">Warna / Tanda</label>
                    <input type="text" name="warna_tanda" value="{{ old('warna_tanda') }}" class="form-control" placeholder="Contoh: Putih belang hitam">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Ras Hewan</label>
                    <select name="idras_hewan" class="form-select">
                        <option value="">-- Pilih Ras --</option>
                        @foreach ($ras as $r)
                            <option value="{{ $r->idras_hewan }}">{{ $r->nama_ras }} ({{ $r->jenisHewan->nama_jenis_hewan }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Pemilik</label>
                    <select name="idpemilik" class="form-select">
                        <option value="">-- Pilih Pemilik --</option>
                        @foreach ($pemilik as $p)
                            <option value="{{ $p->idpemilik }}">{{ $p->user->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.pet') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
