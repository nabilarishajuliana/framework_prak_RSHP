@extends('layouts.adminlte.app')

@section('title', 'Data Hewan')
@section('page_title', 'Data Hewan Pasien')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-semibold text-dark mb-0">
                <i class="bi bi-bug-heart text-success me-2"></i>Daftar Hewan Pasien
            </h5>
            <small class="text-muted">Kelola data hewan dan informasi pemilik</small>
        </div>
        <a href="{{ route('admin.pet.create') }}" class="btn btn-success rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Hewan
        </a>
    </div>

    <div class="card-body pt-3">
         @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-pill px-3 py-2 auto-dismiss">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-pill px-3 py-2 auto-dismiss">
                <i class="bi bi-x-circle me-1"></i> {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive mt-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Hewan</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Warna / Tanda</th>
                        <th>Ras Hewan</th>
                        <th>Pemilik</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pet as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $p->nama }}</span></td>
                            <td>{{ $p->tanggal_lahir ?? '-' }}</td>
                            <td>{{ ucfirst($p->jenis_kelamin) }}</td>
                            <td>{{ $p->warna_tanda ?? '-' }}</td>
                            <td>{{ $p->rasHewan->nama_ras ?? '-' }}</td>
                            <td>{{ $p->pemilik->user->nama ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.pet.edit', $p->idpet) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.pet.destroy', $p->idpet) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted fst-italic py-3">Belum ada data hewan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-end text-muted small mt-3">
            Total data: <strong>{{ $pet->count() }}</strong>
        </div>
    </div>
</div>
@endsection
