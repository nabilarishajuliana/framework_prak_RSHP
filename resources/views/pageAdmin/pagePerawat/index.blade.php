@extends('layouts.adminlte.app')

@section('title', 'Data Perawat')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-nurse text-primary me-2"></i>Data Perawat</h3>
        <p class="text-muted small mb-0">Kelola daftar perawat rumah sakit.</p>
      </div>
      <a href="{{ route('admin.perawat.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">+ Tambah Perawat</a>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show auto-dismiss">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>No HP</th>
              <th>Pendidikan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($perawat as $index => $p)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td><span class="badge bg-info text-dark">{{ $p->user->nama }}</span></td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->no_hp }}</td>
                <td>{{ $p->pendidikan }}</td>
                <td class="text-center">
                  <a href="{{ route('admin.perawat.edit', $p->idperawat) }}" class="btn btn-warning btn-sm rounded-pill px-3">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.perawat.destroy', $p->idperawat) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm rounded-pill px-3"
                      onclick="return confirm('Hapus perawat ini?')">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>

        </table>
      </div>
    </div>

  </div>
</div>

<script>
  setTimeout(() => document.querySelectorAll('.auto-dismiss').forEach(e => e.remove()), 3000);
</script>

@endsection
