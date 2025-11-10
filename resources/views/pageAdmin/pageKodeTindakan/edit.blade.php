@extends('layouts.adminlte.app')

@section('title', 'Edit Kode Tindakan Terapi')
@section('page_title', 'Edit Kode Tindakan Terapi')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0">
        <h5 class="fw-semibold text-warning mb-0">
            <i class="bi bi-pencil-square me-2"></i>Edit Kode Tindakan Terapi
        </h5>
        <small class="text-muted">Perbarui informasi kode tindakan terapi yang sudah terdaftar.</small>
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

        <form action="{{ route('admin.kode.tindakan.update', $tindakan->idkode_tindakan_terapi) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Kode</label>
                <input type="text" name="kode" value="{{ old('kode', $tindakan->kode) }}"
                    class="form-control form-control-lg border-1 rounded-3 @error('kode') is-invalid @enderror">
                @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Deskripsi Tindakan</label>
                <textarea name="deskripsi_tindakan_terapi" rows="3"
                    class="form-control border-1 rounded-3 @error('deskripsi_tindakan_terapi') is-invalid @enderror">{{ old('deskripsi_tindakan_terapi', $tindakan->deskripsi_tindakan_terapi) }}</textarea>
                @error('deskripsi_tindakan_terapi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori</label>
                    <select name="idkategori" class="form-select rounded-3">
                        @foreach ($kategori as $k)
                            <option value="{{ $k->idkategori }}" {{ $tindakan->idkategori == $k->idkategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold text-dark">Kategori Klinis</label>
                    <select name="idkategori_klinis" class="form-select rounded-3">
                        @foreach ($kategoriKlinis as $kk)
                            <option value="{{ $kk->idkategori_klinis }}" {{ $tindakan->idkategori_klinis == $kk->idkategori_klinis ? 'selected' : '' }}>
                                {{ $kk->nama_kategori_klinis }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.kode.tindakan') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
