@extends('layouts.app')

@section('title', 'Antrian Temu Dokter')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Antrian Temu Dokter</h2>
            <p class="text-muted mb-0">Menampilkan antrian <b>hari ini</b>.</p>
        </div>
      <a href="{{ route('resepsionis.dashboard') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
        <a href="#" class="btn btn-primary disabled">+ Daftarkan Pet</a>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Urut</th>
                            <th>Waktu Daftar</th>
                            <th>Nama Pet</th>
                            <th>Pemilik</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($temuDokter as $td)
                        <tr>
                            <td><b>{{ $td->no_urut }}</b></td>
                            <td>{{ $td->waktu_daftar }}</td>
                            <td><span class="badge bg-primary">{{ $td->pet->nama ?? '-' }}</span></td>
                            <td>{{ $td->pet->pemilik->user->nama ?? '-' }}</td>
                            <td>
                                @php
                                $label = $td->status === 'N' ? 'Baru' : ($td->status === 'S' ? 'Selesai' : 'Batal');
                                $color = $td->status === 'N' ? 'secondary' : ($td->status === 'S' ? 'success' : 'danger');
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $label }}</span>
                            </td>
                            <td class="text-center">
                                @if ($td->status !== 'S')
                                <a href="{{ route('resepsionis.temu.dokter.status', [$td->idreservasi_dokter, 'S']) }}" class="btn btn-sm btn-success">Selesai</a>
                                <a href="{{ route('resepsionis.temu.dokter.status', [$td->idreservasi_dokter, 'B']) }}" class="btn btn-sm btn-warning text-white">Batal</a>
                                @endif
                                <form action="{{ route('resepsionis.temu.dokter.delete', $td->idreservasi_dokter) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus antrian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada antrian hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="text-muted small mt-3">Total antrian: {{ $temuDokter->count() }}</p>
        </div>
    </div>
</div>
@endsection