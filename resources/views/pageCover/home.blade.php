<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSHP - Rumah Sakit Hewan Pendidikan</title>
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>
<body>
    {{-- Navbar di-include --}}
    @include('components.navbar')

    <section class="hero">
        <h1>Selamat Datang di RSHP</h1>
        <p>Rumah Sakit Hewan Pendidikan - Memberikan pelayanan kesehatan terbaik dengan teknologi modern dan tenaga medis profesional untuk kesembuhan dan kenyamanan Anda.</p>
        <a href="{{ url('/layanan') }}">Lihat Layanan Kami</a>
    </section>

    <section class="services" id="layanan">
        <h2>Layanan Kami</h2>
        <div class="service-cards">
            <div class="card">
                <img src="https://cdn-icons-png.flaticon.com/512/2966/2966327.png" alt="Rawat Inap">
                <h3>Rawat Inap</h3>
                <p>Fasilitas rawat inap dengan kenyamanan tinggi dan perawatan penuh kasih untuk hewan kesayangan Anda.</p>
            </div>
            <div class="card">
                <img src="https://cdn-icons-png.flaticon.com/512/2966/2966325.png" alt="UGD">
                <h3>Unit Gawat Darurat</h3>
                <p>Pelayanan darurat 24 jam dengan dokter berpengalaman siap menangani kondisi kritis.</p>
            </div>
            <div class="card">
                <img src="https://cdn-icons-png.flaticon.com/512/2966/2966335.png" alt="Rawat Jalan">
                <h3>Rawat Jalan</h3>
                <p>Konsultasi dan pemeriksaan rutin dengan dokter hewan profesional setiap hari.</p>
            </div>
        </div>
    </section>

    @include('components.footer')
</body>
</html>
