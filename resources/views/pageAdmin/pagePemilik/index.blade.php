@extends('layouts.adminlte.app')

@section('title', 'Data Pemilik Hewan')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-person-hearts text-primary me-2"></i>Data Pemilik Hewan</h3>
        <p class="text-muted small mb-0">Kelola daftar pemilik beserta hewan peliharaannya.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.pemilik.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
          + Tambah Pemilik
        </a>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    {{-- ✅ Alert --}}
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

    {{-- ✅ Table --}}
    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama Pemilik</th>
              <th>Alamat</th>
              <th>No. WhatsApp</th>
              <th>Jumlah Hewan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pemilik as $index => $p)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td><span class="badge bg-info text-dark">{{ $p->user->nama ?? '-' }}</span></td>
                <td>{{ $p->alamat ?? '-' }}</td>
                <td>{{ $p->no_wa ?? '-' }}</td>
                <td><span class="badge bg-light text-dark">{{ $p->pet->count() }}</span></td>
                <td class="text-center">
                  <a href="{{ route('admin.pemilik.edit', $p->idpemilik) }}" class="btn btn-warning btn-sm rounded-pill px-3">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.pemilik.destroy', $p->idpemilik) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus pemilik ini?')" class="btn btn-danger btn-sm rounded-pill px-3">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted fst-italic">Belum ada data pemilik.</td></tr>
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
