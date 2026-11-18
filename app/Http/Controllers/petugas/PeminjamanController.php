<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        $anggotas = Anggota::orderBy('nama')->get();
        $bukus = Buku::orderBy('judul')->get();

        return view('petugas.peminjaman.index', compact(
            'peminjamans',
            'anggotas',
            'bukus'
        ));
    }

    // Menyimpan peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
        ], [
            'anggota_id.required' => 'Nama anggota wajib dipilih.',
            'anggota_id.exists' => 'Anggota tidak ditemukan.',
            'buku_id.required' => 'Buku wajib dipilih.',
            'buku_id.exists' => 'Buku tidak ditemukan.',
            'tanggal_pinjam.required' => 'Tanggal peminjaman wajib diisi.',
        ]);

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => null,
        ]);

        return redirect()
            ->route('petugas.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    // Menyetujui pengajuan peminjaman
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('petugas.peminjaman.index')
                ->with('success', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status' => 'disetujui',
        ]);

        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil disetujui!');
    }

    // Menolak pengajuan peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('petugas.peminjaman.index')
                ->with('success', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
        ]);

        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }

    // Mencatat pengembalian buku
    public function returnBook($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return redirect()->route('petugas.peminjaman.index')
                ->with('success', 'Hanya peminjaman yang disetujui yang dapat dikembalikan.');
        }

        if ($peminjaman->tanggal_kembali !== null) {
            return redirect()->route('petugas.peminjaman.index')
                ->with('success', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $peminjaman->update([
            'tanggal_kembali' => now()->toDateString(),
        ]);

       return redirect()->route('petugas.pengembalian.index')
            ->with('success', 'Pengembalian buku berhasil dicatat!');
    }
}
