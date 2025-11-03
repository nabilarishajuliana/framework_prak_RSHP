@extends('layouts.app')

@section('title', 'Edit Kode Tindakan Terapi')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Edit Kode Tindakan Terapi</h2>

    <form action="{{ route('admin.kode.tindakan.update', $tindakan->idkode_tindakan_terapi) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Kode</label>
            <input type="text" name="kode" value="{{ old('kode', $tindakan->kode) }}" class="form-control @error('kode') is-invalid @enderror" required>
            @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Tindakan</label>
            <textarea name="deskripsi_tindakan_terapi" class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror" rows="3" required>{{ old('deskripsi_tindakan_terapi', $tindakan->deskripsi_tindakan_terapi) }}</textarea>
            @error('deskripsi_tindakan_terapi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="idkategori" class="form-select" required>
                @foreach ($kategori as $k)
                    <option value="{{ $k->idkategori }}" {{ $tindakan->idkategori == $k->idkategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori Klinis</label>
            <select name="idkategori_klinis" class="form-select" required>
                @foreach ($kategoriKlinis as $kk)
                    <option value="{{ $kk->idkategori_klinis }}" {{ $tindakan->idkategori_klinis == $kk->idkategori_klinis ? 'selected' : '' }}>
                        {{ $kk->nama_kategori_klinis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kode.tindakan') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
</div>
@endsection
