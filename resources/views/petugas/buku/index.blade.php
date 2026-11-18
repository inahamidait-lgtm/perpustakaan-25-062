@extends('layouts.app')

@section('title', 'Daftar Buku Petugas')

@section('content')

<style>
.petugas-container {
    max-width: 1150px;
    margin: 35px auto;
    padding: 0 22px 30px;
}
.petugas-container h1 {
    color: #243b53;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 8px;
}
.petugas-container p {
    color: #718096;
    margin-bottom: 20px;
}
.table-wrapper {
    overflow-x: auto;
    background: white;
    border: 1px solid #e5eaf0;
    border-radius: 10px;
}
.petugas-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.petugas-table th {
    background: #315f8c;
    color: white;
    padding: 13px;
    text-align: left;
}
.petugas-table td {
    padding: 12px 13px;
    border-bottom: 1px solid #edf0f4;
}
.petugas-table tbody tr:nth-child(even) {
    background: #f8fafc;
}
.petugas-table tbody tr:hover {
    background: #edf4fb;
}
.empty-data {
    text-align: center;
    color: #718096;
}
</style>

<div class="petugas-container">

    <h1>Daftar Buku</h1>
    <p>Berikut adalah data buku yang tersedia di perpustakaan.</p>

    <div class="table-wrapper">
        <table class="petugas-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Tahun Terbit</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($bukus as $buku)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ $buku->kategori->nama ?? '-' }}</td>
                        <td>{{ $buku->tahun_terbit }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-data">
                            Belum ada data buku.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
