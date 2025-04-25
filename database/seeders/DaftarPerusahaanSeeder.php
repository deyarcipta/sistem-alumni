<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarPerusahaanSeeder extends Seeder
{
    public function run()
    {
        DB::table('daftar_perusahaan')->insert([
            [
                'nama_perusahaan'   => 'PT Teknologi Nusantara',
                'foto_perusahaan'   => 'teknologi_nusantara.png',
                'alamat'            => 'Jl. Merdeka No. 123, Jakarta',
                'telepon'           => '021-12345678',
                'website'           => 'https://www.teknologinusantara.co.id',
                'bidang_perusahaan' => 'Teknologi Informasi',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}
