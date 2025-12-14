@extends('layouts.adminlte.app')

@section('title', 'Antrian Temu Dokter')

@section('content')

<div class="app-content-header">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div>
      <h3 class="fw-bold mb-0"><i class="bi bi-calendar-heart text-primary me-2"></i>Antrian Temu Dokter</h3>
      <p class="small text-muted mb-0">Kelola antrian temu dokter hari ini.</p>
    </div>
    <a href="{{ route('resepsionis.temu.create') }}" class="btn btn-primary rounded-pill">+ Tambah Antrian</a>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    {{-- Filter --}}
    <div class="mb-3">
      <a href="{{ route('resepsionis.temu', ['filter' => 'today']) }}" class="btn btn-sm {{ $filter=='today'?'btn-primary':'btn-outline-primary' }}">Hari Ini</a>
      <a href="{{ route('resepsionis.temu', ['filter' => 'all']) }}" class="btn btn-sm {{ $filter=='all'?'btn-primary':'btn-outline-primary' }}">Semua</a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body table-responsive">

        <table class="table table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>No Urut</th>
              <th>Pet</th>
              <th>Pemilik</th>
              <th>Waktu Daftar</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($antrian as $i => $a)
            <tr>
              <td>{{ $i+1 }}</td>
              <td><span class="badge bg-primary">{{ $a->no_urut }}</span></td>

              <td>{{ $a->pet->nama ?? '-' }}</td>
              <td>{{ $a->pet->pemilik->user->nama ?? '-' }}</td>


              <td>{{ \Carbon\Carbon::parse($a->waktu_daftar)->format('d M Y H:i') }}</td>

              <td>
                @if($a->status == 'N')
                <span class="badge bg-warning text-dark">Menunggu</span>
                @else
                <span class="badge bg-success">Selesai</span>
                @endif
              </td>

              <td>
                {{-- STATUS --}}
                @if($a->status == 'N')
                <a href="{{ route('resepsionis.temu.status', [$a->idreservasi_dokter, 'S']) }}"
                  class="btn btn-success btn-sm rounded-pill">Selesai</a>
                @else
                <a href="{{ route('resepsionis.temu.status', [$a->idreservasi_dokter, 'N']) }}"
                  class="btn btn-warning btn-sm rounded-pill">Kembalikan</a>
                @endif

                {{-- DELETE --}}
                <form action="{{ route('resepsionis.temu.destroy', $a->idreservasi_dokter) }}"
                  method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button onclick="return confirm('Hapus antrian ini?')"
                    class="btn btn-danger btn-sm rounded-pill">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center text-muted">Tidak ada antrian.</td>
            </tr>
            @endforelse
          </tbody>

        </table>

      </div>
    </div>

  </div>
</div>

@endsection