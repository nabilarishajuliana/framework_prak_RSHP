@extends('layouts.adminlte.app')

@section('title', 'Data Pasien')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-people text-primary me-2"></i>Data Pasien</h3>
        <p class="text-muted small">Daftar pasien Hari ini</p>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pet</th>
                            <th>Pemilik</th>
                            <th>Dokter Pemeriksa</th>
                            <th>Tanggal Pemeriksaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pasien as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            <td>
                                @if($p->pet)
                                <span class="badge bg-primary">{{ $p->pet->nama }}</span>
                                @if($p->pet->deleted_at)
                                <span class="text-danger fst-italic">(Pet dihapus)</span>
                                @endif
                                @else
                                <span class="text-danger fst-italic">Pet tidak ditemukan</span>
                                @endif
                            </td>

                            <td>{{ optional(optional($p->pet)->pemilik)->user->nama ?? '-' }}</td>

                            <td>{{ optional(optional($p->rekamMedis)->dokterPemeriksa)->user->nama ?? '-' }}</td>

                            <td>
                                @php $ts = optional($p->rekamMedis)->created_at; @endphp
                                {{ $ts ? \Carbon\Carbon::parse($ts)->format('d M Y H:i') : '-' }}
                            </td>

                            <td class="text-center">

                                @php
                                $rmAktif = $p->rekamMedis; // ini sekarang hanya yang AKTIF (deleted_at NULL)
                                @endphp

                                @if(!$rmAktif)
                                {{-- ✅ belum ada rekam medis aktif (atau pernah ada tapi sudah dihapus) --}}
                                <a href="{{ route('dokter.rekammedis.create', $p->idreservasi_dokter) }}"
                                    class="btn btn-success btn-sm rounded-pill px-3">
                                    + Rekam Medis
                                </a>
                                @else
                                {{-- ✅ sudah ada rekam medis aktif --}}
                                <a href="{{ route('dokter.dataPasien.detail', $p->idreservasi_dokter) }}"
                                    class="btn btn-info btn-sm rounded-pill px-3">
                                    Detail
                                </a>
                                @endif


                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted fst-italic">Belum ada data pasien.</td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
@endsection