<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        Anggota::insert([
            [
                'nama' => 'Andi',
                'email' => 'andi@gmail.com',
                'no_telepon' => '081234567890',
            ],
            [
                'nama' => 'Budi',
                'email' => 'budi@gmail.com',
                'no_telepon' => '081234567891',
            ],
            [
                'nama' => 'Citra',
                'email' => 'citra@gmail.com',
                'no_telepon' => '081234567892',
            ],
        ]);
    }
}
