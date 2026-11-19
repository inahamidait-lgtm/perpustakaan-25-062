<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::insert([
            ['nama' => 'Fiksi'],
            ['nama' => 'Non Fiksi'],
            ['nama' => 'Pendidikan'],
        ]);
    }
}
