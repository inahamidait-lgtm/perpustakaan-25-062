<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')
            ->latest()
            ->get();

        return view('petugas.buku.index', compact('bukus'));
    }
}