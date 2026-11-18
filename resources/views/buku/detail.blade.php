@extends('layouts.app')

@section('title', 'Detail Buku - Pustaka Kita')

@section('content')

<div class="detail-page">

    <a href="{{ route('buku.index') }}" class="back-button">
        ← Kembali ke Daftar Buku
    </a>


    <div class="detail-card">

        <div class="detail-image">

            <img
                src="{{ asset($buku['gambar']) }}"
                alt="{{ $buku['judul'] ?? 'Buku' }}"
            >

        </div>


        <div class="detail-content">

            <span class="detail-category">
                {{ $buku['kategori'] ?? 'Novel' }}
            </span>


            <h1 class="detail-title">
                {{ $buku['judul'] ?? 'Judul Buku' }}
            </h1>


        <div class="detail-info">

            <div>
                <p class="detail-label">ID BUKU</p>
                <p class="detail-value">{{ $buku['id'] ?? '-' }}</p>
            </div>

            <div>
                <p class="detail-label">PENULIS</p>
                <p class="detail-value">{{ $buku['penulis'] ?? '-' }}</p>
            </div>

            <div>
                <p class="detail-label">TANGGAL TERBIT</p>
                <p class="detail-value">{{ $buku['tanggal_terbit'] ?? '-' }}</p>
            </div>

        </div>

            <a
                href="{{ route('buku.index') }}"
                class="detail-button"
            >
                Lihat Buku Lainnya
            </a>

        </div>

    </div>

</div>

@endsection