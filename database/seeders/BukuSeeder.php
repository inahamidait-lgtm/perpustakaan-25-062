<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::insert([
            [
                'kategori_id' => 1,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => 2005,
            ],
            [
                'kategori_id' => 2,
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun_terbit' => 1980,
            ],
            [
                'kategori_id' => 3,
                'judul' => 'Pemrograman Web',
                'penulis' => 'Budi Raharjo',
                'tahun_terbit' => 2022,
            ],
            [
                'kategori_id' => 1,
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'tahun_terbit' => 2009,
            ],
            [
                'kategori_id' => 2,
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun_terbit' => 2018,
            ],
        ]);
    }
}
