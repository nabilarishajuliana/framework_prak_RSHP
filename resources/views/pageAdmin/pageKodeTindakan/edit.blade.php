@extends('layouts.adminlte.app')

@section('title', 'Edit Kode Tindakan Terapi')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold mb-0"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Kode Tindakan</h3>
    <p class="text-muted small mb-0">Perbarui data kode tindakan.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <form action="{{ route('admin.kode.tindakan.update', $tindakan->idkode_tindakan_terapi) }}" method="POST">
          @csrf @method('PUT')

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Kode</label>
              <input type="text" name="kode" value="{{ old('kode', $tindakan->kode) }}" class="form-control @error('kode') is-invalid @enderror" required>
              @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-8 mb-3">
              <label class="form-label">Deskripsi Tindakan</label>
              <input type="text" name="deskripsi_tindakan_terapi" value="{{ old('deskripsi_tindakan_terapi', $tindakan->deskripsi_tindakan_terapi) }}" class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror" required>
              @error('deskripsi_tindakan_terapi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Kategori</label>
              <select name="idkategori" class="form-select @error('idkategori') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $k) <option value="{{ $k->idkategori }}" {{ (old('idkategori', $tindakan->idkategori) == $k->idkategori) ? 'selected' : '' }}>{{ $k->nama_kategori }}</option> @endforeach
              </select>
              @error('idkategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Kategori Klinis</label>
              <select name="idkategori_klinis" class="form-select @error('idkategori_klinis') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori Klinis --</option>
                @foreach ($kategoriKlinis as $kk) <option value="{{ $kk->idkategori_klinis }}" {{ (old('idkategori_klinis', $tindakan->idkategori_klinis) == $kk->idkategori_klinis) ? 'selected' : '' }}>{{ $kk->nama_kategori_klinis }}</option> @endforeach
              </select>
              @error('idkategori_klinis') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kode.tindakan') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-warning rounded-pill px-4">Update</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>setTimeout(() => document.querySelectorAll('.alert').forEach(a => a.remove()), 3000);</script>
@endsection
