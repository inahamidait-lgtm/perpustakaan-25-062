<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        $data = Kategori::withCount('bukus')
            ->orderBy('nama')
            ->get()
            ->map(function ($kategori) { 
                return [
                    'kategori_id' => $kategori->id,
                    'kategori' => $kategori->nama,
                    'jumlah_buku' => $kategori->bukus_count,
                ];
            });

        return response()->json([
            'message' => 'Rekap buku per kategori berhasil.',
            'data' => $data,
        ], 200);
    }

    public function peminjamanPerBuku()
    {
        $data = Buku::withCount('peminjamans')
            ->orderByDesc('peminjamans_count')
            ->get()
            ->map(function ($buku) {
                return [
                    'buku_id' => $buku->id,
                    'judul' => $buku->judul,
                    'jumlah_peminjaman' =>
                        $buku->peminjamans_count,
                ];
            });

        return response()->json([
            'message' =>
                'Rekap peminjaman per buku berhasil.',
            'data' => $data,
        ], 200);
    }
}
