<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SertifikatAlumni;

class SertifikatAlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SertifikatAlumni::create([
            'id_alumni' => 1,
            'nama_sertifikat' => 'Sertifikat Pelatihan',
            'tanggal_diterbitkan' => '2024-01-01',
            'file_path' => 'sertifikat/sertifikat_1.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        SertifikatAlumni::create([
            'id_alumni' => 1,
            'nama_sertifikat' => 'Sertifikat USK',
            'tanggal_diterbitkan' => '2023-01-01',
            'file_path' => 'sertifikat/usk.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Add your seeding logic here
    }
}
