@extends('layouts.app')

@section('title', 'Beranda - Pustaka Kita')

@section('content')

<div class="hero-section">

    <div class="hero-grid">

        <div class="hero-text-area">

            <span class="page-label">
                📖
                <span>Ruang baca digital</span>
            </span>

            <h1 class="hero-title">
                Buku yang tepat
                <span>menemukanmu</span>
                di sini.
            </h1>

            <p class="hero-desc">
                Pustaka Kita mengumpulkan koleksi bacaan pilihan
                untuk menemani perjalanan membaca kamu.
            </p>

            <div>
                <a href="{{ route('buku.index') }}" class="hero-button">
                    <span>Jelajahi Daftar Buku</span>
                    <span>→</span>
                </a>
            </div>

        </div>


        <div class="hero-image-wrapper">

            <div class="hero-image-decoration"></div>

            <div class="hero-image-card">

                <img
                    src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80"
                    alt="Rak Buku Pustaka Kita"
                >

            </div>

        </div>

    </div>

</div>

@endsection