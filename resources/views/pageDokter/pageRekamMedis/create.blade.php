@extends('layouts.adminlte.app')

@section('title', 'Tambah Rekam Medis')

@section('content')

<div class="app-content-header">
  <div class="container-fluid">
    <h3 class="fw-bold text-dark mb-2">
      <i class="bi bi-file-plus text-primary me-2"></i>Tambah Rekam Medis
    </h3>
    <p class="text-muted small">Lengkapi data rekam medis berikut.</p>
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

        <form action="{{ route('dokter.rekammedis.store') }}" method="POST">
          @csrf

          {{-- ===================== Pilih Pasien / Antrian ===================== --}}
          <h5 class="fw-semibold text-primary mb-3">Pilih Pasien</h5>
          <div class="mb-3">
            <label class="form-label">Antrian Hari Ini</label>
            <select name="idreservasi" class="form-select" required>
    <option value="">-- Pilih Antrian --</option>

    @foreach ($antrian as $a)
    <option value="{{ $a->idreservasi_dokter }}"
      {{ isset($selectedReservasi) && $selectedReservasi->idreservasi_dokter == $a->idreservasi_dokter ? 'selected' : '' }}>
      No {{ $a->no_urut }} — {{ $a->pet->nama }} ({{ $a->pet->pemilik->user->nama }})
    </option>
    @endforeach
</select>

          </div>

          {{-- ===================== Dokter Pemeriksa ===================== --}}
          <h5 class="fw-semibold text-primary mt-4 mb-3">Dokter Pemeriksa</h5>
          <div class="mb-3">
            <label class="form-label">Pilih Dokter</label>
            <select name="dokter_pemeriksa" class="form-select" required>
              <option value="">-- Pilih Dokter --</option>
              @foreach ($dokter as $d)
              <option value="{{ $d->idrole_user }}">
                {{ $d->user->nama }}
              </option>
              @endforeach
            </select>
          </div>

          {{-- ===================== Data Rekam Medis ===================== --}}
          <h5 class="fw-semibold text-primary mt-4 mb-3">Data Rekam Medis</h5>

          <div class="mb-3">
            <label class="form-label">Anamnesa</label>
            <textarea name="anamnesa" class="form-control" rows="2" required>{{ old('anamnesa') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Temuan Klinis</label>
            <textarea name="temuan_klinis" class="form-control" rows="2" required>{{ old('temuan_klinis') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Diagnosa</label>
            <textarea name="diagnosa" class="form-control" rows="2" required>{{ old('diagnosa') }}</textarea>
          </div>

          {{-- ===================== Tindakan Terapi ===================== --}}
          <h5 class="fw-semibold text-primary mt-4 mb-3">Tindakan Terapi</h5>

          <div id="tindakan-wrapper">

            {{-- ITEM PERTAMA --}}
            <div class="row tindakan-item mb-3">
              <div class="col-md-5">
                <label class="form-label">Kode Tindakan</label>
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
                <label class="form-label">Detail Tindakan</label>
                <input type="text" name="detail[]" class="form-control" required>
              </div>

              <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-success w-100 add-tindakan">
                  + Tambah
                </button>
              </div>
            </div>

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
            <button type="submit" class="btn btn-primary rounded-pill px-4">
              Simpan Rekam Medis
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

@endsection