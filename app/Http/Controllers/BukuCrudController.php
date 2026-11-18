<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuCrudController extends Controller
{
    // Menampilkan semua buku
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->get();

        return view('admin.buku.index', compact('bukus'));
    }

    // Menampilkan form tambah buku
    public function create()
    {
        $kategoris = Kategori::all();

        return view('admin.buku.create', compact('kategoris'));
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'tahun_terbit' => [
                'required',
                'integer',
                'digits:4',
                'min:1000',
                'max:' . date('Y'),
            ],
        ]);

        Buku::create($request->only([
            'kategori_id',
            'judul',
            'penulis',
            'tahun_terbit',
        ]));

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    // Menampilkan detail buku
    public function show(Buku $buku)
    {
        return view('admin.buku.show', compact('buku'));
    }

    // Menampilkan form edit buku
    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();

        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    // Memperbarui data buku
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'tahun_terbit' => [
                'required',
                'integer',
                'digits:4',
                'min:1000',
                'max:' . date('Y'),
            ],
        ]);

        $buku->update($request->only([
            'kategori_id',
            'judul',
            'penulis',
            'tahun_terbit',
        ]));

        return redirect()
            ->route('admin.buku.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    // Menghapus buku
public function destroy(Buku $buku)
{
    if ($buku->peminjamans()->exists()) {
        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.'
            ], 422);
        }

        return redirect()
            ->route('admin.buku.index')
            ->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');
    }

    $buku->delete();

    if (request()->expectsJson()) {
        return response()->json([
            'message' => 'Buku berhasil dihapus!'
        ]);
    }

    return redirect()
        ->route('admin.buku.index')
        ->with('success', 'Buku berhasil dihapus!');
}
}
