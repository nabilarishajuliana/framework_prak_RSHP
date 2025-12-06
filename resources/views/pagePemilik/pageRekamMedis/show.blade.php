@extends('layouts.app')
@section('title', 'Detail Rekam Medis')
@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-file-medical text-success me-2"></i>Detail Rekam Medis
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.rekammedis.index') }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div>
            <!-- <a href="{{ route('pemilik.rekammedis.print', $rekamMedis->idrekam_medis) }}" 
               class="btn btn-outline-primary me-2"
               target="_blank">
                <i class="fas fa-print me-2"></i>Print
            </a> -->
            <a href="{{ route('pemilik.rekammedis.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Info Pasien -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-paw me-2"></i>Informasi Pet
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <!-- <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-paw text-primary" style="font-size: 3rem;"></i>
                        </div> -->
                        <h4 class="fw-bold mb-1">{{ $rekamMedis->temuDokter->pet->nama }}</h4>
                        <p class="text-muted mb-0">{{ $rekamMedis->temuDokter->pet->rasHewan->nama_ras }}</p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Jenis Kelamin</small>
                        <p class="mb-0 fw-semibold">
                            @if($rekamMedis->temuDokter->pet->jenis_kelamin == 'L')
                                <i class="fas fa-mars text-primary me-1"></i>Jantan
                            @else
                                <i class="fas fa-venus text-danger me-1"></i>Betina
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Tgl Lahir</small>
                        <p class="mb-0 fw-semibold">
                            <i class="fas fa-birthday-cake me-1"></i>
                            {{ $rekamMedis->temuDokter->pet->tanggal_lahir }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Umur</small>
                        <p class="mb-0 fw-semibold">
                            <i class="fas fa-birthday-cake me-1"></i>
                            {{ $rekamMedis->temuDokter->pet->umur_text }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Warna / Tanda</small>
                        <p class="mb-0 fw-semibold">
                            <i class="fas fa-palette me-1"></i>
                            {{ $rekamMedis->temuDokter->pet->warna_tanda }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Pemilik</small>
                        <p class="mb-0 fw-semibold">
                            <i class="fas fa-user me-1"></i>
                            {{ $pemilik->user->nama }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Rekam Medis -->
        <div class="col-md-8">
            <!-- Info Pemeriksaan -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>Informasi Pemeriksaan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Tanggal Pemeriksaan</small>
                            <p class="mb-0 fw-semibold">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                {{ \Carbon\Carbon::parse($rekamMedis->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Waktu</small>
                            <p class="mb-0 fw-semibold">
                                <i class="fas fa-clock text-primary me-2"></i>
                                {{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('H:i') }} WIB
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Dokter Pemeriksa</small>
                            <p class="mb-0 fw-semibold">
                                <i class="fas fa-user-md text-success me-2"></i>
                                {{ $rekamMedis->dokterPemeriksa->user->nama ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">No. Antrian</small>
                            <p class="mb-0 fw-semibold">
                                <i class="fas fa-hashtag text-warning me-2"></i>
                                {{ $rekamMedis->temuDokter->no_urut ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Anamnesa -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list text-warning me-2"></i>Anamnesa
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-line;">{{ $rekamMedis->anamnesa }}</p>
                </div>
            </div>

            <!-- Temuan Klinis -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-stethoscope text-info me-2"></i>Temuan Klinis
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0" style="white-space: pre-line;">{{ $rekamMedis->temuan_klinis }}</p>
                </div>
            </div>

            <!-- Diagnosa -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-diagnoses text-danger me-2"></i>Diagnosa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger mb-0">
                        <strong>{{ $rekamMedis->diagnosa }}</strong>
                    </div>
                </div>
            </div>

            <!-- Tindakan & Terapi -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-syringe text-success me-2"></i>Tindakan & Terapi
                    </h5>
                </div>
                <div class="card-body">
                    @if($rekamMedis->detail->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">No</th>
                                        <th width="15%">Kode</th>
                                        <th width="35%">Tindakan/Terapi</th>
                                        <th width="20%">Kategori</th>
                                        <th width="20%">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekamMedis->detail as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $detail->kodeTindakan->kode }}
                                            </span>
                                        </td>
                                        <td>{{ $detail->kodeTindakan->deskripsi_tindakan_terapi }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $detail->kodeTindakan->kategori->nama_kategori ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $detail->detail ?: '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-inbox fs-3 mb-2 d-block opacity-50"></i>
                            Tidak ada tindakan/terapi yang tercatat
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}
</style>
@endsection