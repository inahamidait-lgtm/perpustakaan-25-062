
@extends('layouts.app')

@section('content')

<style>
    .petugas-dashboard {
        min-height: 85vh;
        background: #f4f7fa;
        padding: 25px;
        font-family: Arial, sans-serif;
    }

    /* BANNER SAMBUTAN */
    .petugas-welcome {
        background: linear-gradient(120deg, #2f6090, #3b78ad);
        color: white;
        padding: 38px;
        border-radius: 16px;
        margin-bottom: 30px;
    }

    .petugas-welcome h1 {
        margin: 0 0 12px;
        font-size: 30px;
        font-weight: bold;
    }

    .petugas-welcome p {
        margin: 0;
        color: #e1edf7;
        line-height: 1.6;
    }

    /* JUDUL MENU */
    .petugas-section-title {
        color: #243b53;
        font-size: 21px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    /* GRID KARTU */
    .petugas-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
    }

    /* KARTU MENU */
    .petugas-card {
        background: white;
        padding: 23px;
        border-radius: 13px;
        border: 1px solid #e5ecf2;
        text-decoration: none;
        color: #263b35;
        transition: 0.2s;
        display: block;
    }

    .petugas-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
    }

    .petugas-card .card-icon {
        font-size: 30px;
        margin-bottom: 14px;
    }

    .petugas-card h3 {
        margin: 0 0 9px;
        color: #243b53;
        font-size: 18px;
        font-weight: bold;
    }

    .petugas-card p {
        margin: 0;
        color: #718096;
        font-size: 13px;
        line-height: 1.6;
    }

    /* FOOTER */
    .petugas-footer {
        margin-top: 35px;
        text-align: center;
        color: #8995a3;
        font-size: 12px;
    }

    /* RESPONSIVE */
    @media (max-width: 600px) {
        .petugas-dashboard {
            padding: 15px;
        }

        .petugas-welcome {
            padding: 25px;
        }

        .petugas-welcome h1 {
            font-size: 24px;
        }
    }
</style>

<div class="petugas-dashboard">

    <!-- SAMBUTAN -->
    <section class="petugas-welcome">
        <h1>Selamat Datang, {{ auth()->user()->nama }}!</h1>

        <p>
            Selamat datang di halaman Petugas Pustaka Kita.
            Kelola kegiatan perpustakaan dengan mudah melalui menu yang tersedia.
        </p>
    </section>

    <!-- FOOTER -->
    <div class="petugas-footer">
        © {{ date('Y') }} Pustaka Kita — Sistem Perpustakaan Digital
    </div>

</div>

@endsection
