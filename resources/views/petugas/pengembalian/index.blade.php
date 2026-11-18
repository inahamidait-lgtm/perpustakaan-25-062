
@extends('layouts.app')

@section('content')

<style>
    .pengembalian-container {
        min-height: 85vh;
        background: #f4f7fa;
        padding: 25px;
        font-family: Arial, sans-serif;
    }

    .pengembalian-header {
        background: linear-gradient(120deg, #2f6090, #3b78ad);
        color: white;
        padding: 28px;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .pengembalian-header h1 {
        margin: 0 0 8px;
        font-size: 27px;
        font-weight: bold;
    }

    .pengembalian-header p {
        margin: 0;
        color: #e1edf7;
    }

    .table-card {
        background: white;
        padding: 23px;
        border-radius: 13px;
        border: 1px solid #e5ecf2;
    }

    .section-title {
        color: #243b53;
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    th, td {
        padding: 13px;
        text-align: left;
        border-bottom: 1px solid #e5ecf2;
        font-size: 14px;
    }

    th {
        background: #edf4fb;
        color: #243b53;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .status-dipinjam {
        background: #fff3cd;
        color: #856404;
    }

    .status-kembali {
        background: #d1fae5;
        color: #065f46;
    }

    .btn-kembali {
        background: #315f8c;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-kembali:hover {
        background: #243b53;
    }

    .success-message {
        background: #d1fae5;
        color: #065f46;
        padding: 12px;
        border-radius: 7px;
        margin-bottom: 18px;
    }

    .error-message {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px;
        border-radius: 7px;
        margin-bottom: 18px;
    }

    @media (max-width: 600px) {
        .pengembalian-container {
            padding: 15px;
        }
    }
</style>

<div class="pengembalian-container">

    <section class="pengembalian-header">
        <h1>Data Pengembalian</h1>
        <p>Kelola proses pengembalian buku Pustaka Kita.</p>
    </section>

    {{-- Notifikasi berhasil --}}
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-card">

        <h2 class="section-title">Daftar Peminjaman Buku</h2>

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengembalians as $pengembalian)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $pengembalian->anggota->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $pengembalian->buku->judul ?? '-' }}
                            </td>

                            <td>
                                {{ $pengembalian->tanggal_pinjam }}
                            </td>

                            <td>
                                {{ $pengembalian->tanggal_kembali ?? '-' }}
                            </td>

                            <td>
                                @if($pengembalian->tanggal_kembali)
                                    <span class="status status-kembali">
                                        Dikembalikan
                                    </span>
                                @elseif($pengembalian->status == 'disetujui')
                                    <span class="status status-dipinjam">
                                        Dipinjam
                                    </span>
                                @elseif($pengembalian->status == 'menunggu')
                                    <span class="status status-dipinjam">
                                        Menunggu Persetujuan
                                    </span>
                                @elseif($pengembalian->status == 'ditolak')
                                    <span class="status status-dipinjam">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="status status-dipinjam">
                                        {{ $pengembalian->status }}
                                    </span>
                                @endif
                            </td>

                            <td>

                                @if(
                                    $pengembalian->status == 'disetujui' &&
                                    !$pengembalian->tanggal_kembali
                                )

                                    <form
                                        action="{{ route('petugas.peminjaman.return', $pengembalian->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Catat pengembalian buku ini?')">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn-kembali">
                                            Proses Pengembalian
                                        </button>

                                    </form>

                                @elseif($pengembalian->tanggal_kembali)

                                    <span style="color: #059669;">
                                        Selesai
                                    </span>

                                @else

                                    -

                                @endif

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" style="text-align:center;">
                                Belum ada data peminjaman.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection
