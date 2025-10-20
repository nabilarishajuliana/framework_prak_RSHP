<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hewan Pasien - RSHP</title>
    <link rel="stylesheet" href="{{ asset('css/data-view.css') }}">
</head>
<body>

    @include('components.navbar')

    <div class="data-container">
        <div class="data-header">
            <h2>Data Hewan Pasien</h2>
            <a href="#" class="btn-add">+ Tambah Hewan</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Hewan</th>
                        <th>tanggal lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Ras Hewan</th>
                        <th>Pemilik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pet as $p)
                        <tr>
                            <td>{{ $p->idpet }}</td>
                            <td><span class="badge">{{ $p->nama }}</span></td>
                            <td>{{ $p->tanggal_lahir ?? '-' }} </td>
                            <td>{{ ucfirst($p->jenis_kelamin) ?? '-' }}</td>
                            <td>{{ $p->rasHewan->nama_ras ?? '-' }}</td>
                            <td>{{ $p->pemilik->user->nama ?? '-' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-edit">Edit</button>
                                    <button class="btn-delete">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer-info">
                <p>Total data: {{ $pet->count() }}</p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>
</html>
