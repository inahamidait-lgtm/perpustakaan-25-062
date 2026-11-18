<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController
{
    public function index(Request $request)
    {
        $search = $request->search;
        $kategoris = Kategori::all();

        $daftarBuku = Buku::with('kategori')
            ->when($search, function ($query) use ($search) {
                $query->where('judul', 'like', "%$search%")
                    ->orWhere('penulis', 'like', "%$search%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama', 'like', "%$search%");
                    });
            })
            ->get()
            ->map(function ($buku, $index) {
                $gambar = [
                    'image/foto1.jpeg',
                    'image/foto2.jpeg',
                    'image/foto3.jpeg',
                    'image/foto4.jpeg',
                    'image/foto5.jpeg',
                ];

                return [
                    'id' => $buku->id,
                    'judul' => $buku->judul,
                    'penulis' => $buku->penulis,
                    'tanggal_terbit' => $buku->tahun_terbit,
                    'kategori' => $buku->kategori->nama ?? 'Novel',
                    'gambar' => $gambar[$index % count($gambar)],
                ];
            });

        return view('buku.index', compact(
            'daftarBuku',
            'search',
            'kategoris'
        ));
    }

    public function show($id)
    {
        $bukuData = Buku::with('kategori')->find($id);

        if (!$bukuData) {
            abort(404);
        }

        $buku = [
            'id' => $bukuData->id,
            'judul' => $bukuData->judul,
            'penulis' => $bukuData->penulis,
            'tanggal_terbit' => $bukuData->tahun_terbit,
            'kategori' => $bukuData->kategori->nama ?? 'Novel',
            'gambar' => 'image/foto2.jpeg',
        ];

        return view('buku.detail', compact('buku'));
    }

    // Memperbaiki celah SQL Injection
    public function cari(Request $request)
    {
    $judul = $request->query('judul');

    $hasil = DB::select(
        'SELECT * FROM bukus WHERE judul = ?',
        [$judul]
    );

    return response()->json($hasil);
}
}
