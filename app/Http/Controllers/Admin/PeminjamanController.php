<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    // Menampilkan seluruh data peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with([
            'anggota',
            'buku'
        ])->latest()->get();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // Menyetujui pengajuan peminjaman
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status' => 'disetujui',
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil disetujui!');
    }

    // Menolak pengajuan peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }

    // Mencatat pengembalian buku
    public function returnBook($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Hanya peminjaman yang disetujui yang dapat dikembalikan.');
        }

        if ($peminjaman->tanggal_kembali !== null) {
            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $peminjaman->update([
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Pengembalian buku berhasil dicatat!');
    }
}
