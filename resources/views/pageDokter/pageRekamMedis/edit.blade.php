@extends('layouts.adminlte.app')

@section('title', 'Edit Rekam Medis')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2">
      <i class="bi bi-pencil-square text-warning me-2"></i>Edit Rekam Medis
    </h3>
    <p class="text-muted small">Perbarui data rekam medis berikut.</p>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Terjadi kesalahan:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
      <div class="card-body">

        <form action="{{ route('dokter.rekammedis.update', $rekam->idrekam_medis) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- ===================== Info Pasien (Read Only) ===================== --}}
          <h5 class="fw-semibold text-primary mb-3">
            <i class="bi bi-info-circle me-2"></i>Informasi Pasien
          </h5>
          
          <div class="alert alert-light border" role="alert">
            <div class="row mb-2">
              <div class="col-md-3">
                <strong class="text-muted">Nama Pet:</strong>
              </div>
              <div class="col-md-9">
                {{ $rekam->reservasi->pet->nama ?? '-' }}
                @if($rekam->reservasi && $rekam->reservasi->pet && $rekam->reservasi->pet->rasHewan)
                  <small class="text-muted">({{ $rekam->reservasi->pet->rasHewan->nama_ras }})</small>
                @endif
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-3">
                <strong class="text-muted">Nama Pemilik:</strong>
              </div>
              <div class="col-md-9">
                {{ $rekam->reservasi->pet->pemilik->user->nama ?? '-' }}
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-3">
                <strong class="text-muted">No Antrian:</strong>
              </div>
              <div class="col-md-9">
                <span class="badge bg-info">No. {{ $rekam->reservasi->no_urut ?? '-' }}</span>
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-3">
                <strong class="text-muted">Tanggal Periksa:</strong>
              </div>
              <div class="col-md-9">
                {{ $rekam->created_at ? $rekam->created_at: '-' }} WIB
              </div>
            </div>
          </div>

          <hr class="my-4">

          {{-- ===================== Dokter Pemeriksa ===================== --}}
          <h5 class="fw-semibold text-primary mb-3">Dokter Pemeriksa</h5>
          <div class="mb-3">
            <label class="form-label">Pilih Dokter <span class="text-danger">*</span></label>
            <select name="dokter_pemeriksa" class="form-select" required>
              <option value="">-- Pilih Dokter --</option>
              @foreach ($dokter as $d)
              <option value="{{ $d->idrole_user }}" 
                      {{ $rekam->dokter_pemeriksa == $d->idrole_user ? 'selected' : '' }}>
                {{ $d->user->nama }}
              </option>
              @endforeach
            </select>
          </div>

          {{-- ===================== Data Rekam Medis ===================== --}}
          <h5 class="fw-semibold text-primary mt-4 mb-3">Data Rekam Medis</h5>

          <div class="mb-3">
            <label class="form-label">Anamnesa <span class="text-danger">*</span></label>
            <textarea name="anamnesa" class="form-control" rows="3" required>{{ old('anamnesa', $rekam->anamnesa) }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Temuan Klinis <span class="text-danger">*</span></label>
            <textarea name="temuan_klinis" class="form-control" rows="3" required>{{ old('temuan_klinis', $rekam->temuan_klinis) }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Diagnosa <span class="text-danger">*</span></label>
            <textarea name="diagnosa" class="form-control" rows="3" required>{{ old('diagnosa', $rekam->diagnosa) }}</textarea>
          </div>

          {{-- ===================== Tindakan Terapi ===================== --}}
          <h5 class="fw-semibold text-primary mt-4 mb-3">Tindakan Terapi</h5>

          <div id="tindakan-wrapper">

            {{-- LOAD EXISTING DETAIL --}}
            @foreach($rekam->detail as $index => $detail)
            <div class="row tindakan-item mb-3">
              <div class="col-md-5">
                <label class="form-label">Kode Tindakan</label>
                <select name="idkode_tindakan_terapi[]" class="form-select tindakan-select" required>
                  <option value="">-- Pilih Tindakan --</option>
                  @foreach ($tindakan as $t)
                  <option value="{{ $t->idkode_tindakan_terapi }}" 
                          {{ $detail->idkode_tindakan_terapi == $t->idkode_tindakan_terapi ? 'selected' : '' }}>
                    {{ $t->kode }} — {{ $t->deskripsi_tindakan_terapi }}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-5">
                <label class="form-label">Detail Tindakan</label>
                <input type="text" name="detail[]" class="form-control" 
                       value="{{ $detail->detail }}" required>
              </div>

              <div class="col-md-2 d-flex align-items-end">
                @if($index == 0)
                <button type="button" class="btn btn-success w-100 add-tindakan">
                  + Tambah
                </button>
                @else
                <button type="button" class="btn btn-danger w-100 remove-tindakan">
                  Hapus
                </button>
                @endif
              </div>
            </div>
            @endforeach

          </div>

          {{-- TEMPLATE BARU --}}
          <template id="tindakan-template">
            <div class="row tindakan-item mb-3">
              <div class="col-md-5">
                <select name="idkode_tindakan_terapi[]" class="form-select tindakan-select" required>
                  <option value="">-- Pilih Tindakan --</option>
                  @foreach ($tindakan as $t)
                  <option value="{{ $t->idkode_tindakan_terapi }}">
                    {{ $t->kode }} — {{ $t->deskripsi_tindakan_terapi }}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-5">
                <input type="text" name="detail[]" class="form-control" required>
              </div>

              <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger w-100 remove-tindakan">
                  Hapus
                </button>
              </div>
            </div>
          </template>

          <script>
            // ⛔ Ambil semua ID yang sudah dipilih
            function getSelectedTindakan() {
              let selected = [];
              document.querySelectorAll('.tindakan-select').forEach(s => {
                if (s.value) selected.push(s.value);
              });
              return selected;
            }

            // 🔄 Refresh semua dropdown agar tidak menampilkan kode yang sudah dipilih
            function refreshDropdownOptions() {
              let selected = getSelectedTindakan();

              document.querySelectorAll('.tindakan-select').forEach(select => {
                let currentValue = select.value;

                select.querySelectorAll('option').forEach(opt => {
                  if (!opt.value) return;

                  // hide options already selected by other dropdowns
                  if (selected.includes(opt.value) && opt.value !== currentValue) {
                    opt.hidden = true;
                  } else {
                    opt.hidden = false;
                  }
                });
              });
            }

            // ➕ Tambah baris tindakan
            document.addEventListener('click', function(e) {
              if (e.target.classList.contains('add-tindakan')) {
                let template = document.querySelector('#tindakan-template').content.cloneNode(true);
                document.querySelector('#tindakan-wrapper').appendChild(template);
                refreshDropdownOptions();
              }
            });

            // ❌ Hapus baris tindakan
            document.addEventListener('click', function(e) {
              if (e.target.classList.contains('remove-tindakan')) {
                e.target.closest('.tindakan-item').remove();
                refreshDropdownOptions();
              }
            });

            // 🔄 Update filter saat dropdown berubah
            document.addEventListener('change', function(e) {
              if (e.target.classList.contains('tindakan-select')) {
                refreshDropdownOptions();
              }
            });

            // initial cleanup
            refreshDropdownOptions();
          </script>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('dokter.rekammedis') }}" class="btn btn-outline-secondary rounded-pill px-4">
              Batal
            </a>
            <button type="submit" class="btn btn-warning text-white rounded-pill px-4">
              <i class="bi bi-save me-1"></i> Update Rekam Medis
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

@endsection