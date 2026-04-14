<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Peminjaman</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h2>Bukti Peminjaman Buku</h2>

<p><strong>Nama:</strong> {{ $pengajuan->user->name }}</p>
<p><strong>Email:</strong> {{ $pengajuan->user->email }}</p>
<p><strong>Tanggal Pinjam:</strong> {{ $pengajuan->tanggal_pinjam }}</p>
<p><strong>Tanggal Kembali:</strong> {{ $pengajuan->tanggal_kembali }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Buku</th>
            <th>Judul Buku</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengajuan->details as $i => $detail)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $detail->buku->kode_buku }}</td>
            <td>{{ $detail->buku->judul }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>