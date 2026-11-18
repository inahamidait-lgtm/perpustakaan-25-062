<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // Menampilkan daftar peminjaman dan pengembalian
    public function index()
    {
        $pengembalians = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('petugas.pengembalian.index', compact('pengembalians'));
    }

    // Memproses pengembalian buku
    public function store(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
        ], [
            'tanggal_kembali.required' => 'Tanggal pengembalian wajib diisi.',
            'tanggal_kembali.date' => 'Format tanggal tidak valid.',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->tanggal_kembali !== null) {
            return redirect()
                ->route('petugas.pengembalian.index')
                ->with('error', 'Buku ini sudah dikembalikan.');
        }

        $peminjaman->update([
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        return redirect()
            ->route('petugas.pengembalian.index')
            ->with('success', 'Pengembalian buku berhasil diproses!');
    }
}
