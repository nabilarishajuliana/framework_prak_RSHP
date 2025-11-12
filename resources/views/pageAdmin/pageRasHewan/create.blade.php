@extends('layouts.adminlte.app')

@section('title', 'Tambah Ras Hewan')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2">
      <i class="bi bi-plus-circle text-primary me-2"></i>Tambah Ras Hewan Baru
    </h3>
    <p class="text-muted small mb-0">Isi data ras hewan dengan memilih jenis hewan yang sesuai.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <form action="{{ route('admin.ras.hewan.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nama Ras Hewan</label>
            <input type="text" name="nama_ras" value="{{ old('nama_ras') }}"
              class="form-control @error('nama_ras') is-invalid @enderror" placeholder="Contoh: Persia, Golden Retriever...">
            @error('nama_ras') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Jenis Hewan</label>
            <select name="idjenis_hewan" class="form-select @error('idjenis_hewan') is-invalid @enderror">
              <option value="">-- Pilih Jenis Hewan --</option>
              @foreach ($jenisHewan as $j)
                <option value="{{ $j->idjenis_hewan }}" {{ old('idjenis_hewan') == $j->idjenis_hewan ? 'selected' : '' }}>
                  {{ $j->nama_jenis_hewan }}
                </option>
              @endforeach
            </select>
            @error('idjenis_hewan') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.ras.hewan') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => document.querySelectorAll('.alert').forEach(a => a.remove()), 3000);
</script>
@endsection
