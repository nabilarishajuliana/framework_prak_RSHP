@extends('layouts.adminlte.app')

@section('title', 'Data Pet')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold mb-0"><i class="bi bi-paw text-primary me-2"></i>Data Pet</h3>
        <p class="text-muted small mb-0">Kelola data hewan peliharaan.</p>
      </div>
      <div>
        <a href="{{ route('resepsionis.pet.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
          + Tambah Pet
        </a>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

{{-- Alerts --}}
@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
    <i class="bi bi-check-circle me-1"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif


    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>Warna</th>
              <th>Tgl Lahir</th>
              <th>Ras</th>
              <th>Pemilik</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pets as $i => $p)
              <tr>
                <td>{{ $i+1 }}</td>
                <td class="fw-semibold">{{ $p->nama }}</td>
                <td>{{ $p->jenis_kelamin == 'P' ? 'Betina' : 'Jantan' }}</td>
                <td>{{ $p->warna_tanda }}</td>
                <td>{{ $p->tanggal_lahir }}</td>
                <td>{{ $p->rasHewan->nama_ras ?? '-' }}</td>
                <td>{{ $p->pemilik->user->nama ?? '-' }}</td>
                <td>
                  <a href="{{ route('resepsionis.pet.edit', $p->idpet) }}" class="btn btn-warning btn-sm rounded-pill">
                    <i class="bi bi-pencil"></i>
                  </a>

                  <form action="{{ route('resepsionis.pet.destroy', $p->idpet) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Yakin hapus pet ini?')" class="btn btn-danger btn-sm rounded-pill">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-muted">Tidak ada data pet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection
<script>
  setTimeout(() => {
    document.querySelectorAll('.auto-dismiss')
      .forEach(el => el.remove());
  }, 3000);
</script>
