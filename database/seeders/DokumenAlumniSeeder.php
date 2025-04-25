<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenAlumniSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dokumen_alumni')->insert([
            [
                'id_alumni' => 1,
                'jenis_dokumen' => 'Ijazah',
                'file_path' => 'dokumen/ijazah_1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alumni' => 1,
                'jenis_dokumen' => 'SKHUN',
                'file_path' => 'dokumen/transkrip_1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
