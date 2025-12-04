@extends('layouts.adminlte.app')

@section('title', 'Rekam Medis')

@section('content')
<div class="app-content-header">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold text-dark mb-0">
            <i class="bi bi-journal-medical text-primary me-2"></i>
            Rekam Medis
        </h3>
        <p class="text-muted small mb-0">Daftar semua rekam medis hewan.</p>
    </div>

    <a href="{{ route('perawat.rekammedis.create') }}" 
       class="btn btn-primary btn-sm rounded-pill px-3">
        + Tambah Rekam Medis
    </a>
</div>

</div>

<div class="app-content">
    <div class="container-fluid">

        @if(session('success'))
        <div class="alert alert-success auto-dismiss">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">

                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Hewan</th>
                            <th>Pemilik</th>
                            <th>Tanggal</th>
                            <th>Dokter</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rekam as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            <td>
                                @if ($r->reservasi)
                                {{-- PET ADA --}}
                                @if ($r->reservasi->pet)
                                {{ $r->reservasi->pet->nama }}
                                @if($r->reservasi->pet->deleted_at)
                                <span class="text-danger fst-italic">(Pet telah dihapus)</span>
                                @endif
                                @else
                                <span class="text-danger fst-italic">Pet tidak ditemukan</span>
                                @endif
                                @else
                                {{-- RESERVASI NULL --}}
                                <span class="text-danger fst-italic">Reservasi dihapus</span>
                                @endif

                            </td>

                            <td>
                                {{ $r->reservasi->pet->pemilik->user->nama ?? '-' }}
                            </td>


                            <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M Y H:i') }}</td>

                            <td>{{ $r->dokterPemeriksa->user->nama ?? '-' }}</td>


                            <td class="text-center">
                                <a href="{{ route('perawat.rekammedis.detail', $r->idrekam_medis) }}"
                                    class="btn btn-info btn-sm rounded-pill px-3">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted fst-italic">
                                Belum ada rekam medis.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>
</div>

<script>
    setTimeout(() => document.querySelectorAll('.auto-dismiss').forEach(e => e.remove()), 3000);
</script>
@endsection