<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * Menentukan siapa yang boleh melihat detail peminjaman.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua peminjaman
        if ($user->hasRole('admin') || $user->hasRole('petugas')) {
            return true;
        }

        // Siswa hanya boleh melihat peminjaman miliknya sendiri
        return $peminjaman->anggota?->user_id === $user->id;
    }
}
