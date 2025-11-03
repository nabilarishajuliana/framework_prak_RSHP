@extends('layouts.app')

@section('title', 'Edit Ras Hewan')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-dark">Edit Ras Hewan</h2>

    <form action="{{ route('admin.ras.hewan.update', $rasHewan->idras_hewan) }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Ras Hewan</label>
            <input type="text" name="nama_ras" value="{{ old('nama_ras', $rasHewan->nama_ras) }}" class="form-control @error('nama_ras') is-invalid @enderror" required>
            @error('nama_ras') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Hewan</label>
            <select name="idjenis_hewan" class="form-select @error('idjenis_hewan') is-invalid @enderror" required>
                <option value="">-- Pilih Jenis Hewan --</option>
                @foreach ($jenisHewan as $j)
                    <option value="{{ $j->idjenis_hewan }}" {{ $rasHewan->idjenis_hewan == $j->idjenis_hewan ? 'selected' : '' }}>
                        {{ $j->nama_jenis_hewan }}
                    </option>
                @endforeach
            </select>
            @error('idjenis_hewan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.ras.hewan') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
</div>
@endsection
