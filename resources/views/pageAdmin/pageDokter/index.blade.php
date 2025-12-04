@extends('layouts.adminlte.app')

@section('title', 'Data Dokter')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-person-badge text-primary me-2"></i>Data Dokter</h3>
        <p class="text-muted small mb-0">Kelola data dokter beserta akun user-nya.</p>
      </div>

      <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
        + Tambah Dokter
      </a>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if(session('success'))
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
              <th>Nama Dokter</th>
              <th>Bidang</th>
              <th>Jenis Kelamin</th>
              <th>No HP</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @foreach($dokter as $index => $d)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td><span class="badge bg-info text-dark">{{ $d->user->nama }}</span></td>
                <td>{{ $d->bidang_dokter }}</td>
                <td>{{ $d->jenis_kelamin }}</td>
                <td>{{ $d->no_hp }}</td>
                <td class="text-center">
                  <a href="{{ route('admin.dokter.edit', $d->iddokter) }}" class="btn btn-warning btn-sm rounded-pill">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.dokter.destroy', $d->iddokter) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus dokter ini?')"
                      class="btn btn-danger btn-sm rounded-pill">
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
setTimeout(() => document.querySelectorAll('.auto-dismiss').forEach(a => a.remove()), 3000);
</script>
@endsection
