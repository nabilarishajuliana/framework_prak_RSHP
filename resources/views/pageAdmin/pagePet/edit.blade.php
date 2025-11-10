@extends('layouts.adminlte.app')

@section('title', 'Edit Hewan')
@section('page_title', 'Edit Data Hewan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-warning mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data Hewan</h5>
        <small class="text-muted">Perbarui data hewan dengan benar</small>
    </div>

    <div class="card-body pt-3">
        <form action="{{ route('admin.pet.update', $pet->idpet) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Hewan</label>
                    <input type="text" name="nama" value="{{ old('nama', $pet->nama) }}" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pet->tanggal_lahir) }}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="jantan" {{ $pet->jenis_kelamin == 'jantan' ? 'selected' : '' }}>Jantan</option>
                        <option value="betina" {{ $pet->jenis_kelamin == 'betina' ? 'selected' : '' }}>Betina</option>
                    </select>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold text-dark">Warna / Tanda</label>
                    <input type="text" name="warna_tanda" value="{{ old('warna_tanda', $pet->warna_tanda) }}" class="form-control" placeholder="Contoh: Putih belang hitam">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Ras Hewan</label>
                    <select name="idras_hewan" class="form-select">
                        @foreach ($ras as $r)
                            <option value="{{ $r->idras_hewan }}" {{ $pet->idras_hewan == $r->idras_hewan ? 'selected' : '' }}>
                                {{ $r->nama_ras }} ({{ $r->jenisHewan->nama_jenis_hewan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Pemilik</label>
                    <select name="idpemilik" class="form-select">
                        @foreach ($pemilik as $p)
                            <option value="{{ $p->idpemilik }}" {{ $pet->idpemilik == $p->idpemilik ? 'selected' : '' }}>
                                {{ $p->user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.pet') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
