<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        Peminjaman::insert([
            [
                'anggota_id' => 1,
                'buku_id' => 1,
                'tanggal_pinjam' => '2026-11-18',
                'tanggal_kembali' => '2026-11-25',
                'status' => 'dipinjam',
            ],
            [
                'anggota_id' => 2,
                'buku_id' => 2,
                'tanggal_pinjam' => '2026-11-18',
                'tanggal_kembali' => '2026-11-25',
                'status' => 'dipinjam',
            ],
            [
                'anggota_id' => 3,
                'buku_id' => 3,
                'tanggal_pinjam' => '2026-11-18',
                'tanggal_kembali' => '2026-11-25',
                'status' => 'dipinjam',
            ],
        ]);
    }
}
