<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuWisudaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('buku_wisuda')->insert([
            'tahun' => '2022', // Tahun buku wisuda
            'judul' => 'Buku Wisuda 2022',
            'deskripsi' => 'Dokumentasi alumni tahun 2022',
            'file' => 'buku_wisuda_2022.zip',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
