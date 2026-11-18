
@extends('layouts.app')

@section('content')

<style>
    .peminjaman-page {
        min-height: 85vh;
        background: #f0f6ff;
        padding: 35px 24px;
    }

    .peminjaman-container {
        max-width: 1200px;
        margin: auto;
    }

    .peminjaman-table-wrapper {
        background: white;
        border: 1px solid #e1ebf7;
        border-radius: 13px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(49, 91, 135, .08);
    }

    .peminjaman-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .peminjaman-table thead {
        background: #dceafb;
        color: #315b87;
    }

    .peminjaman-table th,
    .peminjaman-table td {
        padding: 16px;
        font-size: 13px;
        white-space: nowrap;
    }

    .peminjaman-table td {
        color: #315b87;
        border-bottom: 1px solid #edf2f8;
    }

    .peminjaman-table tbody tr:hover {
        background: #f5f9ff;
    }

    .status {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-menunggu {
        background: #fff0d5;
        color: #a36b14;
    }

    .status-disetujui {
        background: #e0f3e8;
        color: #287447;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-kembali {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-aksi {
        display: inline-block;
        padding: 7px 10px;
        border: none;
        border-radius: 6px;
        color: white;
        font-size: 12px;
        cursor: pointer;
        margin: 2px;
    }

    .btn-setujui {
        background: #059669;
    }

    .btn-tolak {
        background: #dc2626;
    }

    .btn-kembali {
        background: #315f8c;
    }

    .success-message {
        padding: 12px;
        background: #d1fae5;
        color: #065f46;
        border-radius: 7px;
        margin-bottom: 18px;
    }

    .data-kosong {
        text-align: center;
        padding: 30px !important;
    }

    @media (max-width: 600px) {
        .peminjaman-page {
            padding: 20px 12px;
        }
    }
</style>

<div class="peminjaman-page">
    <div class="peminjaman-container">

        <div style="background: linear-gradient(135deg, #2f6090, #3b78ad); color: white; padding: 28px; border-radius: 15px; margin-bottom: 25px;">
            <h2 style="margin: 0 0 8px;">Data Peminjaman</h2>
            <p style="margin: 0;">Data seluruh aktivitas peminjaman buku perpustakaan.</p>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="peminjaman-table-wrapper">
            <div style="overflow-x:auto;">

                <table class="peminjaman-table">
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

                        @forelse($peminjamans as $peminjaman)

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $peminjaman->anggota->nama ?? '-' }}
                                </td>

                                <td>
                                    {{ $peminjaman->buku->judul ?? '-' }}
                                </td>

                                <td>
                                    {{ $peminjaman->tanggal_pinjam }}
                                </td>

                                <td>
                                    {{ $peminjaman->tanggal_kembali ?? '-' }}
                                </td>

                                <td>
                                    @if($peminjaman->tanggal_kembali)
                                        <span class="status status-kembali">
                                            Dikembalikan
                                        </span>

                                    @elseif($peminjaman->status == 'menunggu')
                                        <span class="status status-menunggu">
                                            Menunggu
                                        </span>

                                    @elseif($peminjaman->status == 'disetujui')
                                        <span class="status status-disetujui">
                                            Disetujui
                                        </span>

                                    @elseif($peminjaman->status == 'ditolak')
                                        <span class="status status-ditolak">
                                            Ditolak
                                        </span>

                                    @else
                                        <span class="status status-menunggu">
                                            {{ ucfirst($peminjaman->status ?? 'Menunggu') }}
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    {{-- Aksi menyetujui dan menolak --}}
                                    @if($peminjaman->status == 'menunggu')

                                        <form
                                            action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Setujui pengajuan peminjaman ini?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn-aksi btn-setujui">
                                                Setujui
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Tolak pengajuan peminjaman ini?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn-aksi btn-tolak">
                                                Tolak
                                            </button>
                                        </form>

                                    {{-- Aksi pengembalian buku --}}
                                    @elseif($peminjaman->status == 'disetujui' && !$peminjaman->tanggal_kembali)

                                        <form
                                            action="{{ route('admin.peminjaman.return', $peminjaman->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Catat pengembalian buku ini?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn-aksi btn-kembali">
                                                Tandai Dikembalikan
                                            </button>
                                        </form>

                                    {{-- Buku sudah dikembalikan --}}
                                    @elseif($peminjaman->tanggal_kembali)

                                        <span style="color: #059669; font-weight: bold;">
                                            Selesai
                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="data-kosong">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@endsection
