<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">
</head>
<body>
    {{-- Navbar --}}
    @include('components.navbar')

    <header class="kontak-header">
        <h1>Hubungi Kami</h1>
        <p>Kami siap melayani dengan sepenuh hati — untuk hewan kesayangan Anda 🐾</p>
    </header>

    <main class="kontak-container">
        <section class="info-section">
            <div class="info-card">
                <img src="https://cdn-icons-png.flaticon.com/512/535/535239.png" alt="Lokasi">
                <h3>Alamat</h3>
                <p>Jl. Mulyorejo, Kampus C Universitas Airlangga<br>Surabaya, Jawa Timur 60115</p>
            </div>
            <div class="info-card">
                <img src="https://cdn-icons-png.flaticon.com/512/724/724664.png" alt="Telepon">
                <h3>Telepon</h3>
                <p>(031) 591-5550<br>Senin – Sabtu: 08.00 - 17.00</p>
            </div>
            <div class="info-card">
                <img src="https://cdn-icons-png.flaticon.com/512/561/561127.png" alt="Email">
                <h3>Email</h3>
                <p>rshp@unair.ac.id<br>support@rshp.id</p>
            </div>
        </section>

        <section class="map-section">
            <h2>Lokasi Kami</h2>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.126783838877!2d112.79215287506664!3d-7.877110992157688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f9c3f79b66ab%3A0x55ff442b6ef7ef92!2sUniversitas%20Airlangga%20Kampus%20C!5e0!3m2!1sid!2sid!4v1717680000000"
                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </section>

        
    </main>

    {{-- Footer --}}
    @include('components.footer')
</body>
</html>
