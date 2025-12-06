@if($jadwals->count() > 0)
    <div class="row g-3">
        @foreach($jadwals as $jadwal)
        <div class="col-12">
            <div class="card border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- No Urut & Status -->
                        <div class="col-md-2">
                            <div class="text-center">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-2">
                                    <h2 class="fw-bold text-primary mb-0">{{ $jadwal->no_urut }}</h2>
                                    <small class="text-muted">No. Antrian</small>
                                </div>
                                @if($jadwal->status == 'N')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @elseif($jadwal->status == 'S')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Selesai
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Batal
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info Pet & Waktu -->
                        <div class="col-md-5">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-paw text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $jadwal->pet->nama }}</h5>
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $jadwal->pet->rasHewan->nama_ras ?? 'N/A' }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($jadwal->waktu_daftar)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($jadwal->waktu_daftar)->format('H:i') }} WIB
                                </small>
                            </div>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="col-md-3">
                            <div class="mb-2">
                                <small class="text-muted d-block">Pendaftar</small>
                                <span class="fw-semibold">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $jadwal->roleUser->user->nama ?? 'N/A' }}
                                </span>
                            </div>
                            @if($jadwal->rekamMedis)
                            <div>
                                <small class="text-success">
                                    <i class="fas fa-file-medical me-1"></i>
                                    Rekam medis tersedia
                                </small>
                            </div>
                            @endif
                        </div>

                        <!-- Actions
                        <div class="col-md-2 text-end">
                            <a href="{{ route('pemilik.jadwal.show', $jadwal->idreservasi_dokter) }}" 
                               class="btn btn-primary btn-sm mb-2 w-100">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            
                            @if($jadwal->status == 'N')
                            <button onclick="confirmBatal({{ $jadwal->idreservasi_dokter }})" 
                                    class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-times me-1"></i>Batalkan
                            </button>
                            @endif

                            @if($jadwal->rekamMedis)
                            <a href="{{ route('pemilik.rekammedis.show', $jadwal->rekamMedis->idrekam_medis) }}" 
                               class="btn btn-success btn-sm mt-2 w-100">
                                <i class="fas fa-file-medical me-1"></i>Rekam Medis
                            </a>
                            @endif
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-calendar-times text-muted opacity-50" style="font-size: 5rem;"></i>
            </div>
            <h4 class="fw-bold mb-3">Tidak Ada Jadwal</h4>
            <p class="text-muted mb-4">
                Belum ada jadwal temu dokter untuk kategori ini
            </p>
        </div>
    </div>
@endif

<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.15) !important;
}
</style>