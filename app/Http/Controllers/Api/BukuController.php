<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans');

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                    ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        $buku = $query
            ->orderByDesc('tahun_terbit')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'message' => 'Daftar buku berhasil diambil.',
            'data' => BukuResource::collection(
                $buku->getCollection()
            )->resolve(),
            'meta' => [
                'current_page' => $buku->currentPage(),
                'last_page' => $buku->lastPage(),
                'per_page' => $buku->perPage(),
                'total' => $buku->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:2100',
        ]);

        $buku = Buku::create($validated);
        $buku->load('kategori');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => (new BukuResource($buku))->resolve(),
        ], 201);
    }

    public function show(string $id)
    {
        $buku = Buku::with('kategori')
            ->withCount('peminjamans')
            ->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail buku berhasil diambil.',
            'data' => (new BukuResource($buku))->resolve(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:2100',
        ]);

        $buku->update($validated);
        $buku->load('kategori');

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => (new BukuResource($buku))->resolve(),
        ]);
    }

    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        if ($buku->peminjamans()->exists()) {
            return response()->json([
                'message' =>
                    'Buku tidak dapat dihapus karena masih memiliki data peminjaman.',
            ], 409);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus.',
        ]);
    }
}