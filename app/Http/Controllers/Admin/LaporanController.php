<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPeminjaman = Peminjaman::count();

        $totalPengembalian = Peminjaman::whereNotNull('tanggal_kembali')->count();

        $bukus = Buku::with('kategori')->latest()->get();

        $anggotas = Anggota::latest()->get();

        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        $pengembalians = Peminjaman::with(['anggota', 'buku'])
            ->whereNotNull('tanggal_kembali')
            ->latest()
            ->get();

        return view('admin.laporan.index', compact(
            'totalBuku',
            'totalAnggota',
            'totalPeminjaman',
            'totalPengembalian',
            'bukus',
            'anggotas',
            'peminjamans',
            'pengembalians'
        ));
    }
}
