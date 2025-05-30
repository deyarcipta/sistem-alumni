<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'singkatan_jurusan' => 'TJKT',
            'nama_jurusan' => 'Teknik Jaringan Komputer & Telekomunikasi',
        ]);
    }
}
