@extends('layouts.adminlte.app')

@section('title', 'Data Jenis Hewan')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold mb-0">
          <i class="bi bi-paw-fill text-primary me-2"></i>Daftar Jenis Hewan
        </h3>
        <p class="text-muted small mb-0">Kelola berbagai jenis hewan yang terdaftar di sistem.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">← Kembali</a>
        <a href="{{ route('admin.jenis.hewan.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">+ Tambah Jenis</a>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    {{-- 🔔 Alert --}}
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @elseif (session('error'))
      <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- 🐶 Table --}}
    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th style="width:60px">No</th>
              <th>Nama Jenis Hewan</th>
              <th class="text-center" style="width:140px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($jenisHewan as $i => $j)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td><span class="badge bg-info text-dark">{{ $j->nama_jenis_hewan }}</span></td>
                <td class="text-center">
                  <a href="{{ route('admin.jenis.hewan.edit', $j->idjenis_hewan) }}" class="btn btn-sm btn-warning rounded-pill px-3">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.jenis.hewan.destroy', $j->idjenis_hewan) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus jenis hewan ini?')">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="3" class="text-center text-muted fst-italic">Belum ada data jenis hewan.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => document.querySelectorAll('.auto-dismiss').forEach(a => a.remove()), 3000);
</script>
@endsection
