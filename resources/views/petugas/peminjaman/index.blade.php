@extends('layouts.app')

@section('content')

<style>
    .peminjaman-container {
        padding: 25px;
        background: #f4f7fa;
        min-height: 85vh;
        font-family: Arial, sans-serif;
    }

    .peminjaman-header {
        background: linear-gradient(120deg, #2f6090, #3b78ad);
        color: white;
        padding: 28px;
        border-radius: 15px;
        margin-bottom: 25px;
    }

    .peminjaman-header h1 {
        margin: 0 0 8px;
        font-size: 27px;
        font-weight: bold;
    }

    .peminjaman-header p {
        margin: 0;
        color: #e1edf7;
    }

    .form-card, .table-card {
        background: white;
        padding: 23px;
        border-radius: 13px;
        border: 1px solid #e5ecf2;
        margin-bottom: 25px;
    }

    .section-title {
        color: #243b53;
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .form-group label {
        display: block;
        color: #334e68;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 11px;
        border: 1px solid #cbd5e0;
        border-radius: 7px;
        background: white;
    }

    .btn-submit {
        margin-top: 18px;
        background: #315f8c;
        color: white;
        border: none;
        padding: 11px 22px;
        border-radius: 7px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #243b53;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
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
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .menunggu {
        background: #fff3cd;
        color: #856404;
    }

    .disetujui {
        background: #d1fae5;
        color: #065f46;
    }

    .ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .dikembalikan {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-aksi {
        display: inline-block;
        padding: 7px 11px;
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

    .success-message {
        padding: 12px;
        background: #d1fae5;
        color: #065f46;
        border-radius: 7px;
        margin-bottom: 18px;
    }

    .error-message {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    @media (max-width: 600px) {
        .peminjaman-container {
            padding: 15px;
        }
    }
</style>

<div class="peminjaman-container">

    <section class="peminjaman-header">
        <h1>Data Peminjaman</h1>
        <p>Kelola pengajuan dan data peminjaman buku Pustaka Kita.</p>
    </section>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- FORM TAMBAH PEMINJAMAN -->
    <div class="form-card">
        <h2 class="section-title">Tambah Peminjaman</h2>

        <form action="{{ route('petugas.peminjaman.store') }}" method="POST">
            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label for="anggota_id">Nama Anggota</label>
                    <select name="anggota_id" id="anggota_id">
                        <option value="">-- Pilih Anggota --</option>

                        @foreach($anggotas as $anggota)
                            <option value="{{ $anggota->id }}"
                                {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                {{ $anggota->nama }}
                            </option>
                        @endforeach
                    </select>

                    @error('anggota_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="buku_id">Judul Buku</label>
                    <select name="buku_id" id="buku_id">
                        <option value="">-- Pilih Buku --</option>

                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}"
                                {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                {{ $buku->judul }}
                            </option>
                        @endforeach
                    </select>

                    @error('buku_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Peminjaman</label>
                    <input type="date"
                        name="tanggal_pinjam"
                        id="tanggal_pinjam"
                        value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">

                    @error('tanggal_pinjam')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button type="submit" class="btn-submit">
                + Simpan Peminjaman
            </button>
        </form>
    </div>

    <!-- TABEL PEMINJAMAN -->
    <div class="table-card">
        <h2 class="section-title">Daftar Peminjaman</h2>

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
                    @forelse($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                            <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>

                            <td>
                                @if($peminjaman->tanggal_kembali)
                                    <span class="status dikembalikan">
                                        Dikembalikan
                                    </span>
                                @elseif($peminjaman->status == 'menunggu')
                                    <span class="status menunggu">
                                        Menunggu
                                    </span>
                                @elseif($peminjaman->status == 'disetujui')
                                    <span class="status disetujui">
                                        Disetujui
                                    </span>
                                @elseif($peminjaman->status == 'ditolak')
                                    <span class="status ditolak">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="status menunggu">
                                        {{ ucfirst($peminjaman->status ?? 'Menunggu') }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($peminjaman->status == 'menunggu')
                                    <form action="{{ route('petugas.peminjaman.approve', $peminjaman->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Setujui pengajuan peminjaman ini?')">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn-aksi btn-setujui">
                                            Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('petugas.peminjaman.reject', $peminjaman->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Tolak pengajuan peminjaman ini?')">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn-aksi btn-tolak">
                                            Tolak
                                        </button>
                                    </form>
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