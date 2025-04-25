<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PengalamanKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan pengalaman kerja untuk alumni tertentu (dengan id_alumni)
        DB::table('pengalaman_kerja')->insert([
            [
                'id_alumni' => 1, // Ganti dengan ID alumni yang sesuai
                'nama_pekerjaan' => 'Software Engineer',
                'nama_perusahaan' => 'PT. Teknologi Canggih',
                'tahun_awal' => 2020,
                'tahun_akhir' => 2023,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
