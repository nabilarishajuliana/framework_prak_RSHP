@extends('layouts.app')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Detail Rekam Medis</h2>
        <a href="{{ route('dokter.rekammedis') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>

   

@section('title', 'Detail Rekam Medis - Perawat')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold text-dark mb-0">Detail Rekam Medis</h2>
            <small class="text-muted">
                Hewan: <strong>{{ $rekamMedis->temuDokter->pet->nama ?? '-' }}</strong> —
                Pemilik: {{ $rekamMedis->temuDokter->pet->pemilik->user->nama ?? '-' }} —
                Dokter: <strong>{{ $rekamMedis->dokter->user->nama ?? '-' }}</strong> —
                No. Urut: #{{ $rekamMedis->temuDokter->no_urut ?? '-' }}
            </small>
        </div>
        <a href="{{ route('perawat.rekammedis') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>

    <!-- Rekam Medis Header -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="mb-3">
                <h6 class="fw-semibold text-muted">Anamnesa</h6>
                <p class="mb-0">{{ $rekamMedis->anamnesa ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <h6 class="fw-semibold text-muted">Temuan Klinis</h6>
                <p class="mb-0">{{ $rekamMedis->temuan_klinis ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <h6 class="fw-semibold text-muted">Diagnosa</h6>
                <p class="mb-0">{{ $rekamMedis->diagnosa ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Tindakan -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="fw-semibold mb-0 text-dark">Detail Tindakan / Terapi</h5>
        </div>
        <div class="card-body">
            @if ($details->isEmpty())
                <p class="text-muted text-center mb-0">Belum ada detail tindakan untuk rekam medis ini.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Kode Tindakan</th>
                                <th>Deskripsi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                                <tr>
                                    <td>{{ $d->iddetail_rekam_medis }}</td>
                                    <td><strong>{{ $d->kodeTindakanTerapi->kode ?? '-' }}</strong></td>
                                    <td>{{ $d->kodeTindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}</td>
                                    <td>{{ $d->detail ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <footer class="text-center text-muted small mt-4">
        &copy; {{ date('Y') }} Rumah Sakit Hewan | Developed by Princess Risha 👑
    </footer>
</div>
@endsection
Dokter->no_urut ?? '-' }}</strong> —
                Dokter: <strong>{{ $rekamMedis->dokter->user->nama ?? '-' }}</strong> —
                Daftar: {{ $rekamMedis->temuDokter->waktu_daftar ?? '-' }}
            </p>

            <div class="mb-3">
                <h6 class="fw-semibold">Anamnesa</h6>
                <div class="border rounded p-2 bg-light">{{ $rekamMedis->anamnesa ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <h6 class="fw-semibold">Temuan Klinis</h6>
                <div class="border rounded p-2 bg-light">{{ $rekamMedis->temuan_klinis ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <h6 class="fw-semibold">Diagnosa</h6>
                <div class="border rounded p-2 bg-light">{{ $rekamMedis->diagnosa ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="fw-semibold mb-0">Detail Tindakan / Terapi</h5>
        </div>
        <div class="card-body">
            @if ($rekamMedis->detailRekamMedis->isEmpty())
                <p class="text-muted mb-0">Belum ada tindakan / terapi.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Deskripsi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekamMedis->detailRekamMedis as $d)
                                <tr>
                                    <td>{{ $d->iddetail_rekam_medis }}</td>
                                    <td><strong>{{ $d->kodeTindakanTerapi->kode ?? '-' }}</strong></td>
                                    <td>{{ $d->kodeTindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}</td>
                                    <td>{{ $d->detail ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <footer class="text-center text-muted small mt-4">
        &copy; {{ date('Y') }} Rumah Sakit Hewan | Developed by Princess Risha 👑
    </footer>
</div>
@endsection
