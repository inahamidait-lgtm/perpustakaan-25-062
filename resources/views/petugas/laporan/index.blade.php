@extends('layouts.app')

@section('title', 'Laporan Petugas')

@section('content')

<style>
.petugas-container {
    max-width: 1150px;
    margin: 35px auto;
    padding: 0 22px 20px;
    color: #486078;
}
.petugas-container h1 {
    color: #243b53;
    font-size: 28px;
    font-weight: bold;
}
.petugas-container p {
    color: #718096;
}
.laporan-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}
.print-button {
    background: #315f8c;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    cursor: pointer;
}
.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}
.summary-card, .report-section {
    background: white;
    border: 1px solid #e5eaf0;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
.summary-card h3 {
    color: #718096;
    font-size: 14px;
}
.summary-card .number {
    color: #315f8c;
    font-size: 28px;
    font-weight: bold;
}
.report-section h2 {
    color: #243b53;
    font-size: 19px;
    font-weight: bold;
    margin-bottom: 15px;
}
.table-wrapper {
    overflow-x: auto;
}
.report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.report-table th {
    background: #315f8c;
    color: white;
    padding: 12px;
    text-align: left;
}
.report-table td {
    padding: 12px;
    border-bottom: 1px solid #edf0f4;
}
.report-table tbody tr:nth-child(even) {
    background: #f8fafc;
}
.empty-data {
    text-align: center;
    color: #718096;
}
@media(max-width: 800px) {
    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media(max-width: 600px) {
    .laporan-top {
        align-items: flex-start;
        flex-direction: column;
    }
    .summary-grid {
        grid-template-columns: 1fr;
    }
}
@media print {
    .print-button, nav, header {
        display: none !important;
    }
    .petugas-container {
        margin: 0;
        padding: 0;
    }
}
</style>

<div class="petugas-container">

    <div class="laporan-top">
        <div>
            <h1>Laporan Perpustakaan</h1>
            <p>Ringkasan data perpustakaan oleh petugas.</p>
        </div>

        <button class="print-button" onclick="window.print()">
            Cetak PDF
        </button>
    </div>

    {{-- RINGKASAN --}}
    <div class="summary-grid">
        <div class="summary-card">
            <h3>Total Buku</h3>
            <div class="number">{{ $totalBuku }}</div>
        </div>

        <div class="summary-card">
            <h3>Total Anggota</h3>
            <div class="number">{{ $totalAnggota }}</div>
        </div>

        <div class="summary-card">
            <h3>Total Peminjaman</h3>
            <div class="number">{{ $totalPeminjaman }}</div>
        </div>

        <div class="summary-card">
            <h3>Total Pengembalian</h3>
            <div class="number">{{ $totalPengembalian }}</div>
        </div>
    </div>

    {{-- DATA BUKU --}}
    <div class="report-section">
        <h2>Data Buku</h2>
        <div class="table-wrapper">
            <table class="report-table">
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
                            <td colspan="5" class="empty-data">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DATA ANGGOTA --}}
    <div class="report-section">
        <h2>Data Anggota</h2>
        <div class="table-wrapper">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anggotas as $anggota)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $anggota->nama }}</td>
                            <td>{{ $anggota->email }}</td>
                            <td>{{ $anggota->no_telepon }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-data">Belum ada data anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DATA PEMINJAMAN --}}
    <div class="report-section">
        <h2>Data Peminjaman</h2>
        <div class="table-wrapper">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                            <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-data">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DATA PENGEMBALIAN --}}
    <div class="report-section">
        <h2>Data Pengembalian</h2>
        <div class="table-wrapper">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengembalians as $pengembalian)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pengembalian->anggota->nama ?? '-' }}</td>
                            <td>{{ $pengembalian->buku->judul ?? '-' }}</td>
                            <td>{{ $pengembalian->tanggal_pinjam }}</td>
                            <td>{{ $pengembalian->tanggal_kembali }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-data">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
