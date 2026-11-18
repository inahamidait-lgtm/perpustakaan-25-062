<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    // Menampilkan riwayat peminjaman milik Siswa
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->whereHas('anggota', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('siswa.peminjaman.index', compact('peminjamans'));
    }

    // Mengajukan peminjaman buku
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ], [
            'buku_id.required' => 'Buku harus dipilih.',
            'buku_id.exists' => 'Buku tidak ditemukan.',
        ]);

        // Mencari anggota berdasarkan akun yang sedang login
        $anggota = Anggota::where('user_id', Auth::id())->first();

        if (!$anggota) {
            return response()->json([
                'message' => 'Data anggota belum terhubung dengan akun kamu.'
            ], 422);
        }

        // Memeriksa pengajuan atau peminjaman aktif
        $sudahMengajukan = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $validated['buku_id'])
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->exists();

        if ($sudahMengajukan) {
            return response()->json([
                'message' => 'Kamu masih memiliki pengajuan atau peminjaman aktif untuk buku ini.'
            ], 422);
        }

        // Menyimpan pengajuan dengan status menunggu
        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $validated['buku_id'],
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'menunggu',
        ]);

        return response()->json([
            'message' => 'Pengajuan peminjaman berhasil dikirim. Silakan tunggu persetujuan Petugas.'
        ], 201);
    }

    // Menampilkan detail peminjaman
    public function show($id)
    {
    $peminjaman = Peminjaman::findOrFail($id);

    Gate::authorize('view', $peminjaman);

    return view('siswa.peminjaman.detail', compact('peminjaman'));
    }

}
