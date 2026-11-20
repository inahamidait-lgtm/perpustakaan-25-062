@extends('layouts.app')

@section('title', 'Daftar Buku - Pustaka Kita')

@section('content')
@php
    $bolehKelolaBuku = auth()->user()->can('kelola data buku');
    $bolehPinjamBuku = auth()->user()->can('mengajukan peminjaman buku');
@endphp

<style>
    .buku-container {
        max-width: 1150px;
        margin: 35px auto;
        padding: 0 22px;
    }

    .form-card, .table-card {
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        border: 1px solid #e5eaf0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        margin-bottom: 25px;
    }

    .form-card h2, .table-card h2 {
        color: #243b53;
        font-size: 21px;
        margin: 0 0 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .form-group label {
        display: block;
        color: #334e68;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #d9e2ec;
        border-radius: 8px;
        background: #fff;
        color: #334e68;
        outline: none;
        font-size: 14px;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #4776a8;
        box-shadow: 0 0 0 3px rgba(71,118,168,0.12);
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        border: none;
        border-radius: 8px;
        padding: 10px 17px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn:hover {
        opacity: 0.85;
        transform: translateY(-1px);
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-simpan {
        background: #315f8c;
        color: white;
    }

    .btn-batal {
        background: #e9eef4;
        color: #334e68;
    }

    .btn-ubah {
        background: #e8f1fb;
        color: #245b91;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .btn-hapus {
        background: #fdeaea;
        color: #c0392b;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .btn-pinjam {
        background: #315f8c;
        color: white;
    }

    .pesan {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
        font-size: 14px;
    }

    .pesan.berhasil {
        display: block;
        background: #e8f7ee;
        color: #247345;
    }

    .pesan.gagal {
        display: block;
        background: #fdeaea;
        color: #b83232;
    }

    .table-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .total-buku {
        background: #edf4fb;
        color: #315f8c;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .tabel-buku {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .tabel-buku th {
        background: #315f8c;
        color: white;
        text-align: left;
        padding: 14px 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .tabel-buku td {
        padding: 13px 12px;
        border-bottom: 1px solid #edf0f4;
        color: #486078;
        font-size: 13px;
    }

    .tabel-buku tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    .tabel-buku tbody tr:hover {
        background: #edf4fb;
    }

    .tabel-buku th:first-child,
    .tabel-buku td:first-child {
        text-align: center;
        width: 45px;
    }

    @media (max-width: 650px) {
        .buku-container {
            padding: 0 12px;
            margin: 22px auto;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-card, .table-card {
            padding: 17px;
        }
    }
</style>

<div class="buku-container">
    <div style="background:linear-gradient(135deg,#2f6090,#3b78ad);color:white;padding:28px;border-radius:15px;margin-bottom:25px;">
        <h2 style="margin:0 0 8px;color:white;">Data Buku</h2>
        <p style="margin:0;">Berikut adalah daftar buku yang ingin kamu pinjam.</p>
    </div>

    @if (session('success'))
        <div class="pesan berhasil">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="pesan gagal">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="pesan gagal">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <div id="pesan" class="pesan" style="display:none;" role="status" aria-live="polite"></div>

    @if ($bolehKelolaBuku)
        <div class="form-card" id="form-card-buku">
            <h2 id="judul-form">Tambah Buku</h2>
            {{-- Menggunakan route WEB Laravel; tidak menggunakan /api/buku. --}}
            <form id="form-buku" method="POST" action="{{ url('/buku') }}">
                @csrf
                <input type="hidden" name="_method" id="metode-form" value="POST" disabled>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="kategori_id">Kategori Buku</label>
                        <select id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input id="judul" name="judul" type="text" value="{{ old('judul') }}" placeholder="Masukkan judul buku" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input id="penulis" name="penulis" type="text" value="{{ old('penulis') }}" placeholder="Masukkan nama penulis" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit</label>
                        <input id="tahun_terbit" name="tahun_terbit" type="number" min="1000" max="{{ date('Y') }}" value="{{ old('tahun_terbit') }}" placeholder="Contoh: 2024" required>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="tombol-simpan" class="btn btn-simpan">Simpan Buku</button>
                    <button type="button" id="tombol-batal" class="btn btn-batal" hidden>Batal</button>
                </div>
            </form>
        </div>
    @endif

    <div class="table-card">
        <div class="table-heading">
            <h2>Koleksi Buku</h2>
            <span class="total-buku" id="jumlah-buku">Total buku: {{ $daftarBuku->count() }}</span>
        </div>
        <div class="table-wrapper">
            <table class="tabel-buku">
                <thead><tr>
                    <th>No</th><th>Kategori</th><th>Judul Buku</th><th>Penulis</th><th>Tahun Terbit</th>
                    @if ($bolehKelolaBuku || $bolehPinjamBuku)<th>Aksi</th>@endif
                </tr></thead>
                <tbody id="daftar-buku">
                @forelse ($daftarBuku as $index => $buku)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $buku['kategori'] }}</td>
                        <td>{{ $buku['judul'] }}</td>
                        <td>{{ $buku['penulis'] }}</td>
                        <td>{{ $buku['tanggal_terbit'] }}</td>
                        @if ($bolehKelolaBuku || $bolehPinjamBuku)
                            <td>
                                @if ($bolehKelolaBuku)
                                    <button type="button" class="btn btn-ubah js-edit"
                                        data-id="{{ $buku['id'] }}"
                                        data-kategori-id="{{ $buku['kategori_id'] }}"
                                        data-judul="{{ $buku['judul'] }}"
                                        data-penulis="{{ $buku['penulis'] }}"
                                        data-tahun="{{ $buku['tanggal_terbit'] }}">Ubah</button>
                                    <form class="aksi-form js-hapus" method="POST" action="{{ url('/buku/'.$buku['id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-hapus">Hapus</button>
                                    </form>
                                @endif
                                @if ($bolehPinjamBuku)
                                    <button type="button" class="btn btn-pinjam js-pinjam"
                                        data-id="{{ $buku['id'] }}" data-judul="{{ $buku['judul'] }}">Pinjam Buku</button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ ($bolehKelolaBuku || $bolehPinjamBuku) ? 6 : 5 }}" style="text-align:center;">Belum ada data buku.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Data tabel sudah di-render Blade. Tidak ada fetch('/api/buku').
    const pesan = document.getElementById('pesan');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const baseBukuUrl = @json(url('/buku'));

    function tampilkanPesan(teks, berhasil = false) {
        if (!pesan) return;
        pesan.textContent = teks;
        pesan.className = 'pesan ' + (berhasil ? 'berhasil' : 'gagal');
        pesan.style.display = 'block';
    }

    // Edit dan tambah buku memakai route WEB (POST /buku, PUT /buku/{id}).
    const form = document.getElementById('form-buku');
    const metode = document.getElementById('metode-form');
    const tombolBatal = document.getElementById('tombol-batal');
    const judulForm = document.getElementById('judul-form');
    const tombolSimpan = document.getElementById('tombol-simpan');

    function resetForm() {
        if (!form) return;
        form.reset();
        form.action = baseBukuUrl;
        if (metode) {
            metode.value = 'POST';
            metode.disabled = true;
        }
        if (judulForm) judulForm.textContent = 'Tambah Buku';
        if (tombolSimpan) tombolSimpan.textContent = 'Simpan Buku';
        if (tombolBatal) tombolBatal.hidden = true;
    }

    document.querySelectorAll('.js-edit').forEach(button => {
        button.addEventListener('click', () => {
            if (!form || !metode) return;
            document.getElementById('kategori_id').value = button.dataset.kategoriId || '';
            document.getElementById('judul').value = button.dataset.judul || '';
            document.getElementById('penulis').value = button.dataset.penulis || '';
            document.getElementById('tahun_terbit').value = button.dataset.tahun || '';
            form.action = baseBukuUrl + '/' + encodeURIComponent(button.dataset.id);
            metode.value = 'PUT';
            metode.disabled = false;
            if (judulForm) judulForm.textContent = 'Ubah Buku';
            if (tombolSimpan) tombolSimpan.textContent = 'Simpan Perubahan';
            if (tombolBatal) tombolBatal.hidden = false;
            document.getElementById('form-card-buku')?.scrollIntoView({ behavior: 'smooth' });
        });
    });

    tombolBatal?.addEventListener('click', resetForm);

    document.querySelectorAll('.js-hapus').forEach(formHapus => {
        formHapus.addEventListener('submit', event => {
            if (!confirm('Yakin ingin menghapus buku ini?')) event.preventDefault();
        });
    });

    // Pengajuan peminjaman tetap memakai route WEB /siswa/peminjaman.
    // Tidak memanggil API buku ataupun memuat ulang tabel melalui AJAX.
    document.querySelectorAll('.js-pinjam').forEach(button => {
        button.addEventListener('click', async () => {
            if (!confirm('Ajukan peminjaman buku "' + button.dataset.judul + '"?')) return;
            button.disabled = true;
            try {
                const response = await fetch(@json(url('/siswa/peminjaman')), {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify({ buku_id: Number(button.dataset.id) })
                });
                const data = await response.json().catch(() => ({}));
                if (!response.ok) {
                    const detail = data.errors ? Object.values(data.errors).flat().join(' ') : '';
                    throw new Error(detail || data.message || 'Gagal mengajukan peminjaman (' + response.status + ').');
                }
                tampilkanPesan(data.message || 'Pengajuan peminjaman berhasil.', true);
            } catch (error) {
                tampilkanPesan(error.message || 'Terjadi kesalahan saat mengajukan peminjaman.');
            } finally {
                button.disabled = false;
            }
        });
    });
});
</script>
@endsection