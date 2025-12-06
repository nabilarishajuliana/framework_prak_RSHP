@extends('layouts.adminlte.app')

@section('title', 'Detail Rekam Medis - Admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-2">
                <i class="bi bi-file-medical me-2 text-primary"></i>
                Detail Rekam Medis
            </h3>
            <p class="text-muted small">Halaman administrator – akses penuh data rekam medis.</p>
        </div>

        <a href="{{ route('admin.rekammedis') }}" class="btn btn-secondary btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- Informasi Pasien --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-3">Informasi Pasien</h5>

                @php $pet = $rekam->reservasi->pet; @endphp

                <p><strong>Nama Hewan:</strong>
                    @if ($pet)
                        {{ $pet->nama }}
                        @if ($pet->deleted_at)
                            <span class="text-danger fst-italic">(Pet telah dihapus)</span>
                        @endif
                    @else
                        <span class="text-danger fst-italic">Pet tidak ditemukan</span>
                    @endif
                </p>

                <p><strong>Pemilik:</strong>
                    {{ $pet->pemilik->user->nama ?? '-' }}
                </p>

                <p><strong>Tanggal Rekam Medis:</strong>
                    {{ \Carbon\Carbon::parse($rekam->created_at)->format('d M Y - H:i') }} WIB
                </p>

                <p><strong>Dokter Pemeriksa:</strong>
                    {{ $rekam->dokterPemeriksa->user->nama ?? '-' }}
                </p>

            </div>
        </div>

        {{-- Detail Rekam Medis --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <h5 class="fw-bold text-primary mb-3">Data Rekam Medis</h5>

                <p><strong>Anamnesa:</strong> {{ $rekam->anamnesa }}</p>
                <p><strong>Temuan Klinis:</strong> {{ $rekam->temuan_klinis }}</p>
                <p><strong>Diagnosa:</strong> {{ $rekam->diagnosa }}</p>

                <hr>

                <h5 class="fw-bold text-primary mb-3">Tindakan Terapi</h5>

                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Tindakan</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekam->detail as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $d->kodeTindakan->kode ?? '-' }}</td>
                                <td>{{ $d->kodeTindakan->deskripsi_tindakan_terapi ?? '-' }}</td>
                                <td>{{ $d->detail }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted fst-italic">
                                    Tidak ada tindakan terapi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@endsection
