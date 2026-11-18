@extends('layouts.app')

@section('content')

<style>
    .admin-dashboard {
        min-height: 85vh;
        background: #f4f7f6;
        padding: 25px;
        font-family: Arial, sans-serif;
    }

    .admin-welcome {
        background: linear-gradient(120deg, #2f6090, #3b78ad);
        color: white;
        padding: 38px;
        border-radius: 16px;
        margin-bottom: 28px;
    }
    
    .admin-welcome h1 {
        margin: 0 0 12px;
        font-size: 30px;
    }

    .admin-welcome p {
        margin: 0;
        color: #e1eee9;
    }

    .admin-section-title {
        color: ;
        margin-bottom: 18px;
    }

    .admin-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
    }

    .admin-card {
        background: white;
        padding: 23px;
        border-radius: 13px;
        border: 1px solid #e5ece9;
        text-decoration: none;
        color: #263b35;
        transition: 0.2s;
        display: block;
    }

    .admin-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 22px rgba(0,0,0,0.08);
    }

    .admin-card .card-icon {
        font-size: 30px;
        margin-bottom: 14px;
    }

    .admin-card h3 {
        margin: 0 0 9px;
        color: #173b35;
    }

    .admin-card p {
        margin: 0;
        color: #71817b;
        font-size: 13px;
        line-height: 1.6;
    }

    .admin-footer {
        margin-top: 30px;
        text-align: center;
        color: #89958f;
        font-size: 12px;
    }
</style>

<div class="admin-dashboard">

    {{-- SAMBUTAN --}}
    <section class="admin-welcome">
        <h1>Selamat Datang, {{ auth()->user()->nama }}!</h1>
        <p>
            Dashboard Admin Perpustakaan Digital.
            Kelola seluruh aktivitas perpustakaan dengan mudah melalui halaman ini.
        </p>
    </section>

    <div class="admin-footer">
        © {{ date('Y') }} Pustaka Kita — Sistem Perpustakaan Digital
    </div>

</div>

@endsection
