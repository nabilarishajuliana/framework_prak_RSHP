<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Umum - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/layanan.css') }}">
</head>
<body>

    {{-- Navbar --}}
    @include('components.navbar')

    <header class="layanan-header">
        <h1>Layanan Umum</h1>
        <p>Pelayanan profesional dan penuh kasih untuk hewan kesayangan Anda</p>
    </header>

    <main class="layanan-container">

        <section class="intro">
            <p>
                Rumah Sakit Hewan Pendidikan Universitas Airlangga melakukan layanan-layanan, baik atas kehendak klien
                atau rujukan dokter hewan praktisi sebagai berikut:
            </p>
        </section>

        <section class="layanan-section">
            <h2>Poliklinik</h2>
            <p>
                Poliklinik adalah layanan rawat jalan dimana pelayanan kesehatan hewan dilakukan tanpa pasien menginap.
                Poliklinik melayani tindakan observasi, diagnosis, pengobatan, rehabilitasi medik, serta pelayanan kesehatan
                lainnya seperti permintaan surat keterangan sehat.
            </p>
            <ul>
                <li>Rawat jalan</li>
                <li>Vaksinasi</li>
                <li>Akupuntur</li>
                <li>Kemoterapi</li>
                <li>Fisioterapi</li>
                <li>Mandi terapi</li>
            </ul>
        </section>

        <section class="layanan-section">
            <h2>Rawat Inap</h2>
            <p>
                Rawat inap dilakukan pada pasien-pasien yang berat atau parah dan membutuhkan perawatan intensif. Pasien akan
                diobservasi dan mendapat perawatan di bawah pengawasan dokter dan paramedis yang handal.
            </p>
        </section>

        <section class="layanan-section">
            <h2>Bedah</h2>
            <div class="bedah-grid">
                <div>
                    <h3>Tindakan Bedah Minor</h3>
                    <ul>
                        <li>Jahit luka</li>
                        <li>Kastrasi</li>
                        <li>Othematoma</li>
                        <li>Scaling – root planning</li>
                        <li>Ekstraksi gigi</li>
                    </ul>
                </div>
                <div>
                    <h3>Tindakan Bedah Mayor</h3>
                    <ul>
                        <li>Gastrotomi; Entrotomi; Enterektomi; Salivary mucocele</li>
                        <li>Ovariohisterektomi; Sectio caesar; Piometra</li>
                        <li>Sistotomi; Urethrostomi</li>
                        <li>Fraktur tulang</li>
                        <li>Hernia (diafragmatika, perinealis, inguinalis)</li>
                        <li>Eksisi tumor</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="layanan-section">
            <h2>Pemeriksaan</h2>
            <ul>
                <li>Pemeriksaan Sitologi</li>
                <li>Pemeriksaan Dermatologi</li>
                <li>Pemeriksaan Hematologi</li>
                <li>Pemeriksaan Radiografi</li>
                <li>Pemeriksaan Ultrasonografi</li>
            </ul>
            <p>
                Selain layanan medis, Rumah Sakit Hewan Pendidikan Universitas Airlangga juga melayani grooming pada hewan kesayangan.
            </p>
        </section>

    </main>

    {{-- Footer --}}
    @include('components.footer')

</body>
</html>
