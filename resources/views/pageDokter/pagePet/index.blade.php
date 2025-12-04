@extends('layouts.adminlte.app')

@section('title', 'Data Pet')

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-paw text-primary me-2"></i>Data Pet</h3>
        <p class="text-muted small mb-0">Kelola daftar hewan peliharaan beserta pemilik dan rasnya.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
          ← Kembali
        </a>
        <a href="{{ route('admin.pet.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
          + Tambah Pet
        </a>
      </div>
    </div>
  </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
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
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>Warna / Tanda</th>
              <th>Tanggal Lahir</th>
              <th>Ras Hewan</th>
              <th>Pemilik</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pets as $index => $p)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td><span class="badge bg-primary">{{ $p->nama }}</span></td>
                <td>{{ strtoupper($p->jenis_kelamin) == 'P' ? 'Betina' : 'Jantan' }}</td>
                <td>{{ $p->warna_tanda ?? '-' }}</td>
                <td>{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d M Y') : '-' }}</td>
                <td>{{ $p->rasHewan->nama_ras ?? '-' }}</td>
                <td>{{ $p->pemilik->user->nama ?? '-' }}</td>
                <td class="text-center">
                  <a href="{{ route('admin.pet.edit', $p->idpet) }}" class="btn btn-warning btn-sm rounded-pill px-3">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.pet.destroy', $p->idpet) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus data pet ini?')" class="btn btn-danger btn-sm rounded-pill px-3">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-muted fst-italic">Belum ada data pet.</td></tr>
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
