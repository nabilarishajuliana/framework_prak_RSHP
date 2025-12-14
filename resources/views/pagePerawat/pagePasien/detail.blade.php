@extends('layouts.adminlte.app')

@section('title', 'Detail Pasien')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2"><i class="bi bi-file-medical text-info me-2"></i>Detail Pasien</h3>
    <p class="text-muted small mb-0">Informasi lengkap pasien & rekam medis.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    <div class="card shadow-sm border-0 mb-3">
      <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">Informasi Pasien</h5>

        <p><strong>Nama Pet:</strong>
          {{ $data->pet->nama ?? '-' }}
          @if($data->pet && $data->pet->deleted_at)
            <span class="text-danger fst-italic">(Pet dihapus)</span>
          @endif
        </p>

        <p><strong>Pemilik:</strong> {{ $data->pet->pemilik->user->nama ?? '-' }}</p>

        <p><strong>Dokter Pemeriksa:</strong> 
          {{ $data->rekamMedisAll->dokterPemeriksa->user->nama ?? '-' }}
        </p>

        <p><strong>Tanggal Pemeriksaan:</strong>
          {{ $data->rekamMedisAll->created_at ? \Carbon\Carbon::parse($data->rekamMedisAll->created_at)->format('d M Y H:i') : '-' }}
        </p>
      </div>
    </div>


    {{-- Detail Rekam Medis --}}
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">Detail Rekam Medis</h5>

        @forelse($data->rekamMedisAll->detail as $d)
        <div class="border p-3 rounded mb-3">
          <p><strong>Tindakan/Terapi:</strong> {{ $d->kodeTindakan->deskripsi_tindakan_terapi ?? '-' }}</p>
          <p><strong>Detail:</strong> {{ $d->detail ?? '-' }}</p>
        </div>
        @empty
        <p class="text-muted fst-italic">Belum ada detail rekam medis.</p>
        @endforelse

      </div>
    </div>

  </div>
</div>
@endsection
