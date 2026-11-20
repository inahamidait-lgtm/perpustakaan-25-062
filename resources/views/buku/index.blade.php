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

    <!-- Banner Daftar Buku -->
    <div style="background: linear-gradient(135deg, #2f6090, #3b78ad); color: white; padding: 28px; border-radius: 15px; margin-bottom: 25px;">
        <h2 style="margin: 0 0 8px; color: white;">Data Buku</h2>
        <p style="margin: 0;">Berikut adalah daftar buku yang ingin kamu pinjam.</p>
    </div>

    <!-- Form Tambah dan Ubah Buku untuk Admin/Petugas -->
    @if ($bolehKelolaBuku)
        <div class="form-card">

            <h2 id="judul-form">Tambah Buku</h2>

            <form id="form-buku">
                @csrf

                <input type="hidden" id="buku_id">

                <div class="form-grid">

                    <div class="form-group">
                        <label for="kategori_id">Kategori Buku</label>

                        <select id="kategori_id" required>
                            <option value="">Pilih kategori</option>

                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" id="judul"
                            placeholder="Masukkan judul buku" required>
                    </div>

                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" id="penulis"
                            placeholder="Masukkan nama penulis" required>
                    </div>

                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit</label>
                        <input type="number" id="tahun_terbit"
                            placeholder="Contoh: 2024" required>
                    </div>

                </div>

                <div class="form-actions">

                    <button type="submit" id="tombol-simpan"
                        class="btn btn-simpan">
                        Simpan Buku
                    </button>

                    <button type="button" id="tombol-batal"
                        class="btn btn-batal" hidden>
                        Batal
                    </button>

                </div>
            </form>
        </div>
    @endif

    <!-- Pesan Berhasil atau Gagal -->
    <div id="pesan" class="pesan"></div>

    <!-- Tabel Daftar Buku -->
    <div class="table-card">

        <div class="table-heading">
            <h2>Koleksi Buku</h2>

            <span class="total-buku" id="jumlah-buku">
                Memuat data...
            </span>
        </div>

        <div class="table-wrapper">

            <table class="tabel-buku">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>

                        @if ($bolehKelolaBuku || $bolehPinjamBuku)
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody id="daftar-buku">
                    <tr>
                        <td colspan="{{ ($bolehKelolaBuku || $bolehPinjamBuku) ? 6 : 5 }}">
                            Memuat data buku...
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const api = '/api/buku';

    const bolehKelolaBuku = @json($bolehKelolaBuku);
    const bolehPinjamBuku = @json($bolehPinjamBuku);

    const tabel = document.getElementById('daftar-buku');
    const pesan = document.getElementById('pesan');
    const jumlahBuku = document.getElementById('jumlah-buku');

    let daftarBuku = [];

    const form = document.getElementById('form-buku');
    const idInput = document.getElementById('buku_id');

    const judulForm = document.getElementById('judul-form');
    const tombolSimpan = document.getElementById('tombol-simpan');
    const tombolBatal = document.getElementById('tombol-batal');

    function tampilkanPesan(teks, berhasil = false) {
        pesan.textContent = teks;
        pesan.className = 'pesan ' + (berhasil ? 'berhasil' : 'gagal');
    }

    function ambilTokenCSRF() {
        const cookie = document.cookie
            .split('; ')
            .find(row => row.startsWith('XSRF-TOKEN='));

        return cookie
            ? decodeURIComponent(cookie.split('=').slice(1).join('='))
            : null;
    }

    async function permintaan(url, opsi = {}) {

        const tokenCSRF = ambilTokenCSRF();

        const response = await fetch(url, {
            ...opsi,
            credentials: 'same-origin',

            headers: {
                'Accept': 'application/json',

                ...(opsi.body
                    ? { 'Content-Type': 'application/json' }
                    : {}),

                ...(tokenCSRF
                    ? { 'X-XSRF-TOKEN': tokenCSRF }
                    : {}),

                ...opsi.headers
            }
        });

        const hasil = await response.json().catch(() => ({}));

        if (!response.ok) {

            const detailValidasi = hasil.errors
                ? Object.values(hasil.errors).flat().join(' ')
                : '';

            throw new Error(
                detailValidasi ||
                hasil.message ||
                `Permintaan gagal (${response.status}).`
            );
        }

        return hasil;
    }

    function buatSel(baris, nilai) {
        const sel = document.createElement('td');
        sel.textContent = nilai ?? '-';
        baris.appendChild(sel);
        return sel;
    }

    function judulBuku(buku) {
        return buku.judul ?? buku.judul_buku ?? '-';
    }

    // Mengambil data buku dari API
    async function muatBuku() {

        try {

            const hasil = await permintaan(api);

            daftarBuku = hasil.data || [];

            tabel.replaceChildren();

            if (daftarBuku.length === 0) {

                const baris = document.createElement('tr');

                const sel = buatSel(baris, 'Belum ada data buku.');

                sel.colSpan = (bolehKelolaBuku || bolehPinjamBuku) ? 6 : 5;

                tabel.appendChild(baris);
            }

            daftarBuku.forEach((buku, index) => {

                const baris = document.createElement('tr');

                buatSel(baris, index + 1);
                buatSel(baris, buku.kategori);
                buatSel(baris, judulBuku(buku));
                buatSel(baris, buku.penulis);
                buatSel(baris, buku.tahun_terbit);

                // Tombol Aksi
                if (bolehKelolaBuku || bolehPinjamBuku) {

                    const aksi = document.createElement('td');

                    // Tombol Ubah dan Hapus untuk Admin/Petugas
                    if (bolehKelolaBuku) {

                        const ubah = document.createElement('button');

                        ubah.textContent = 'Ubah';
                        ubah.type = 'button';
                        ubah.className = 'btn btn-ubah';

                        ubah.addEventListener('click', () => isiForm(buku));

                        const hapus = document.createElement('button');

                        hapus.textContent = 'Hapus';
                        hapus.type = 'button';
                        hapus.className = 'btn btn-hapus';

                        hapus.addEventListener('click', () => hapusBuku(buku));

                        aksi.append(ubah, hapus);
                    }

                    // Tombol Pinjam Buku untuk Siswa
                    if (bolehPinjamBuku) {

                        const pinjam = document.createElement('button');

                        pinjam.textContent = 'Pinjam Buku';
                        pinjam.type = 'button';
                        pinjam.className = 'btn btn-pinjam';

                        pinjam.addEventListener('click', () => ajukanPeminjaman(buku));

                        aksi.appendChild(pinjam);
                    }

                    baris.appendChild(aksi);
                }

                tabel.appendChild(baris);
            });

            jumlahBuku.textContent =
                `Total buku: ${daftarBuku.length}`;

        } catch (error) {

            tabel.replaceChildren();

            const baris = document.createElement('tr');

            const sel = buatSel(baris, error.message);

            sel.colSpan = (bolehKelolaBuku || bolehPinjamBuku) ? 6 : 5;

            tabel.appendChild(baris);

            jumlahBuku.textContent = 'Gagal memuat data';

            tampilkanPesan('Gagal mengambil data: ' + error.message);
        }
    }

    // Mengisi form ketika tombol Ubah diklik
    function isiForm(buku) {

        idInput.value = buku.id;

        document.getElementById('kategori_id').value =
            buku.kategori_id ?? '';

        document.getElementById('judul').value =
            judulBuku(buku) === '-' ? '' : judulBuku(buku);

        document.getElementById('penulis').value =
            buku.penulis ?? '';

        document.getElementById('tahun_terbit').value =
            buku.tahun_terbit ?? '';

        judulForm.textContent = 'Ubah Buku';

        tombolSimpan.textContent = 'Simpan Perubahan';

        tombolBatal.hidden = false;

        tampilkanPesan('Data buku dipilih untuk diubah.', true);

        form.scrollIntoView({ behavior: 'smooth' });
    }

    // Mengosongkan form
    function resetForm() {

        form.reset();

        idInput.value = '';

        judulForm.textContent = 'Tambah Buku';

        tombolSimpan.textContent = 'Simpan Buku';

        tombolBatal.hidden = true;
    }

    // Tambah dan Ubah Buku untuk Admin/Petugas
    if (bolehKelolaBuku) {

        tombolBatal.addEventListener('click', () => {

            resetForm();

            tampilkanPesan('Perubahan dibatalkan.', true);
        });

        form.addEventListener('submit', async (event) => {

            event.preventDefault();

            tombolSimpan.disabled = true;

            const id = idInput.value;

            const data = {

                kategori_id: Number(
                    document.getElementById('kategori_id').value
                ),

                judul: document.getElementById('judul').value.trim(),

                penulis: document.getElementById('penulis').value.trim(),

                tahun_terbit: Number(
                    document.getElementById('tahun_terbit').value
                )
            };

            try {

                const hasil = await permintaan(
                    id ? `${api}/${id}` : api,
                    {
                        method: id ? 'PUT' : 'POST',
                        body: JSON.stringify(data)
                    }
                );

                resetForm();

                await muatBuku();

                tampilkanPesan(
                    hasil.message || 'Data buku berhasil disimpan.',
                    true
                );

            } catch (error) {

                tampilkanPesan(
                    'Gagal menyimpan buku: ' + error.message
                );

            } finally {

                tombolSimpan.disabled = false;
            }
        });
    }

    // Menghapus Buku
    async function hapusBuku(buku) {

        if (!bolehKelolaBuku) return;

        if (!confirm(
            `Yakin ingin menghapus buku "${judulBuku(buku)}"?`
        )) return;

        try {

            const hasil = await permintaan(
                `${api}/${buku.id}`,
                { method: 'DELETE' }
            );

            await muatBuku();

            tampilkanPesan(
                hasil.message || 'Buku berhasil dihapus.',
                true
            );

        } catch (error) {

            tampilkanPesan(
                'Gagal menghapus buku: ' + error.message
            );
        }
    }

    // Mengajukan Peminjaman Buku untuk Siswa
    async function ajukanPeminjaman(buku) {

        if (!bolehPinjamBuku) return;

        if (!confirm(
            `Apakah kamu yakin ingin mengajukan peminjaman buku "${judulBuku(buku)}"?`
        )) {
            return;
        }

        try {

            const hasil = await permintaan('/siswa/peminjaman', {
                method: 'POST',
                body: JSON.stringify({
                    buku_id: buku.id
                })
            });

            tampilkanPesan(
                hasil.message || 'Pengajuan berhasil dikirim.',
                true
            );

        } catch (error) {

            tampilkanPesan(
                'Pengajuan gagal: ' + error.message
            );
        }
    }

    // Menampilkan data buku saat halaman dibuka
    muatBuku();

});
</script>

@endsection
