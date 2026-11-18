
@extends('layouts.app')

@section('content')

<style>
    .siswa-dashboard {
        min-height: 85vh;
        background: #f4f7fa;
        padding: 25px;
        font-family: Arial, sans-serif;
    }

    .siswa-welcome {
        background: linear-gradient(120deg, #2f6090, #3b78ad);
        color: white;
        padding: 38px;
        border-radius: 16px;
        margin-bottom: 30px;
    }

    .siswa-welcome h1 {
        margin: 0 0 12px;
        font-size: 30px;
        font-weight: bold;
    }

    .siswa-welcome p {
        margin: 0;
        color: #e1edf7;
        line-height: 1.6;
    }

    .siswa-section-title {
        color: #243b53;
        font-size: 21px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .siswa-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
    }

    .siswa-card {
        background: white;
        padding: 23px;
        border-radius: 13px;
        border: 1px solid #e5ecf2;
        text-decoration: none;
        display: block;
        transition: 0.2s;
    }

    .siswa-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 22px rgba(0,0,0,0.08);
    }

    .siswa-card .card-icon {
        font-size: 30px;
        margin-bottom: 14px;
    }

    .siswa-card h3 {
        margin: 0 0 9px;
        color: #243b53;
        font-size: 18px;
        font-weight: bold;
    }

    .siswa-card p {
        margin: 0;
        color: #718096;
        font-size: 13px;
        line-height: 1.6;
    }

    .siswa-footer {
        margin-top: 35px;
        text-align: center;
        color: #8995a3;
        font-size: 12px;
    }

    @media (max-width: 600px) {
        .siswa-dashboard {
            padding: 15px;
        }

        .siswa-welcome {
            padding: 25px;
        }

        .siswa-welcome h1 {
            font-size: 24px;
        }
    }
</style>

<div class="siswa-dashboard">

    <section class="siswa-welcome">
        <h1>Selamat Datang, {{ auth()->user()->nama }}!</h1>

        <p>
            Selamat datang di Pustaka Kita.
            Temukan berbagai koleksi buku dan pantau riwayat
            peminjamanmu melalui halaman ini.
        </p>
    </section>

    <div class="siswa-footer">
        © {{ date('Y') }} Pustaka Kita — Sistem Perpustakaan Digital
    </div>

</div>

@endsection
