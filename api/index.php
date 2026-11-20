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