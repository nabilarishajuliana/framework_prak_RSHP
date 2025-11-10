@extends('layouts.adminlte.app')

@section('title', 'Data Pemilik Hewan')
@section('page_title', 'Data Pemilik Hewan')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-semibold text-dark mb-0">
                <i class="bi bi-person-hearts text-primary me-2"></i>Daftar Pemilik Hewan
            </h5>
            <small class="text-muted">Kelola data pemilik beserta hewan peliharaannya</small>
        </div>
        <a href="{{ route('admin.pemilik.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pemilik
        </a>
    </div>

    <div class="card-body pt-3">

        {{-- ✅ Success / Error Message --}}
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
                        <th style="width:5%">No</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat</th>
                        <th>No. WhatsApp</th>
                        <th>Jumlah Hewan</th>
                        <th style="width:18%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemilik as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-info bg-opacity-10 text-info px-3 py-2 fw-semibold">{{ $p->user->nama ?? '-' }}</span></td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->no_wa }}</td>
                            <td>{{ $p->pet->count() }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.pemilik.edit', $p->idpemilik) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.pemilik.destroy', $p->idpemilik) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus data pemilik ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4 fst-italic">Belum ada data pemilik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-end text-muted small mt-3">
            Total data: <strong>{{ $pemilik->count() }}</strong>
        </div>
    </div>
</div>
@endsection
