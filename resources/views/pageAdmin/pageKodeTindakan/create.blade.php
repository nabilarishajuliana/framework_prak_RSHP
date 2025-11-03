@extends('layouts.app')

@section('title', 'Tambah Kode Tindakan Terapi')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Tambah Kode Tindakan Terapi</h2>

    <form action="{{ route('admin.kode.tindakan.store') }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf
        <div class="mb-3">
            <label class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode tindakan" required>
            @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Tindakan</label>
            <textarea name="deskripsi_tindakan_terapi" class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi tindakan" required></textarea>
            @error('deskripsi_tindakan_terapi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="idkategori" class="form-select @error('idkategori') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->idkategori }}">{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            @error('idkategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori Klinis</label>
            <select name="idkategori_klinis" class="form-select @error('idkategori_klinis') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori Klinis --</option>
                @foreach ($kategoriKlinis as $kk)
                    <option value="{{ $kk->idkategori_klinis }}">{{ $kk->nama_kategori_klinis }}</option>
                @endforeach
            </select>
            @error('idkategori_klinis') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kode.tindakan') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
