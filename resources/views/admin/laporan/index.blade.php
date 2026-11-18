@extends('layouts.app')

@section('title', 'Laporan Perpustakaan - Pustaka Kita')

@section('content')

<style>
    .laporan-container {
        max-width: 1150px;
        margin: 35px auto;
        padding: 0 22px 20px;
        color: #486078;
    }

    /* HEADER */
    .laporan-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .laporan-header h1 {
        color: #243b53;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .laporan-header p {
        color: #718096;
        font-size: 14px;
    }

    /* TOMBOL CETAK */
    .print-button {
        background: #315f8c;
        color: white;
        border: none;
        padding: 11px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
    }

    .print-button:hover {
        background: #243b53;
    }

    /* RINGKASAN DATA */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        border: 1px solid #e5eaf0;
        border-radius: 10px;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .summary-card h3 {
        color: #718096;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .summary-card .number {
        color: #315f8c;
        font-size: 28px;
        font-weight: bold;
    }

    /* BAGIAN TABEL */
    .report-section {
        background: white;
        border: 1px solid #e5eaf0;
        border-radius: 10px;
        padding: 22px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .report-section h2 {
        color: #243b53;
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .table-wrapper {
        width: 100%;
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
        padding: 13px;
        text-align: left;
        white-space: nowrap;
    }

    .report-table td {
        padding: 12px 13px;
        border-bottom: 1px solid #edf0f4;
    }

    .report-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    .report-table tbody tr:hover {
        background: #edf4fb;
    }

    .empty-data {
        text-align: center;
        color: #718096;
        padding: 20px !important;
    }

    /* JARAK BAWAH TABEL TERAKHIR */
    .report-section:last-child {
        margin-bottom: 5px;
    }

    /* RESPONSIVE */
    @media (max-width: 800px) {
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .laporan-top {
            align-items: flex-start;
            flex-direction: column;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }
    }

    /* CETAK PDF */
    @media print {
        .print-button,
        nav,
        header {
            display: none !important;
        }

        .laporan-container {
            margin: 0;
            max-width: 100%;
            padding: 0;
        }

        .report-section,
        .summary-card {
            box-shadow: none;
            break-inside: avoid;
        }

        .report-section {
            margin-bottom: 20px;
        }
    }
</style>

<div class="laporan-container">

    {{-- JUDUL DAN TOMBOL CETAK --}}
    <div class="laporan-top">

        <div style="background: linear-gradient(135deg, #2f6090, #3b78ad); color: white; padding: 28px; border-radius: 15px; margin-bottom: 25px;">
            <h2 style="margin: 0 0 8px;">Laporan Perpustakaan</h2>
            <p style="margin: 0;">Ringkasan data buku, anggota, peminjaman, dan pengembalian perpustakaan.</p>
        </div>

        <button class="print-button" onclick="window.print()">
            Cetak PDF
        </button>

    </div>

    {{-- RINGKASAN DATA --}}
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
                            <td colspan="5" class="empty-data">
                                Belum ada data buku.
                            </td>
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
                            <td colspan="4" class="empty-data">
                                Belum ada data anggota.
                            </td>
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
                            <td>
                                {{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-data">
                                Belum ada data peminjaman.
                            </td>
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
                            <td colspan="5" class="empty-data">
                                Belum ada data pengembalian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
