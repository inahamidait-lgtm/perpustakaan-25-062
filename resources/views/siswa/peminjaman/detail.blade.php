
@extends('layouts.app')

@section('content')

<style>
    .detail-container {
        max-width: 850px;
        margin: 40px auto;
        padding: 20px;
    }

    .detail-header {
        background: linear-gradient(135deg, #2f6090, #3b78ad);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .detail-header h2 {
        margin: 0 0 10px;
        font-size: 24px;
    }

    .detail-header p {
        margin: 0;
    }

    .detail-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    }

    .detail-row {
        display: grid;
        grid-template-columns: 190px 1fr;
        gap: 15px;
        padding: 14px 5px;
        border-bottom: 1px solid #eeeeee;
    }

    .detail-label {
        font-weight: 600;
        color: #444;
    }

    .detail-value {
        color: #555;
    }

    .btn-kembali {
        display: inline-block;
        margin-top: 25px;
        background: #315f8c;
        color: white;
        padding: 11px 22px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-kembali:hover {
        background: #23476c;
        color: white;
    }

    @media (max-width: 600px) {
        .detail-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }

        .detail-container {
            padding: 15px;
        }
    }
</style>

<div class="detail-container">

    <div class="detail-header">
        <h2>Detail Peminjaman</h2>
        <p>Informasi lengkap peminjaman buku.</p>
    </div>

    <div class="detail-card">

        <div class="detail-row">
            <div class="detail-label">ID Peminjaman</div>
            <div class="detail-value">{{ $peminjaman->id }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Nama Anggota</div>
            <div class="detail-value">
                {{ $peminjaman->anggota->nama ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Judul Buku</div>
            <div class="detail-value">
                {{ $peminjaman->buku->judul ?? '-' }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Tanggal Pinjam</div>
            <div class="detail-value">
                {{ $peminjaman->tanggal_pinjam }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Tanggal Kembali</div>
            <div class="detail-value">
                {{ $peminjaman->tanggal_kembali ?? '-' }}
            </div>
        </div>

        <a href="{{ route('siswa.peminjaman.index') }}"
           class="btn-kembali">
            ← Kembali
        </a>

    </div>

</div>

@endsection
