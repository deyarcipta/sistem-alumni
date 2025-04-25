<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumni;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alumni')->delete();
        DB::table('alumni')->insert([
            [
                'nama' => 'Deyar Cipta Rizky',
                'nis' => '112233',
                'nisn' => '1234567890',
                'id_jurusan' => '1',
                'tahun_lulus' => '2023',
                'password' => bcrypt('password'),
                'foto' => 'default.jpg',
                'status' => 'Bekerja',
                'tanggal_lahir' => '2004-05-17',
                'tempat_lahir' => 'Bandung',
                'alamat' => 'Jl. Merdeka No. 123',
                'no_hp' => '081234567890',
                'email' => 'rizky@example.com',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'status_pernikahan' => 'Belum Menikah',
                'kewargaan' => 'Indonesia',
                'sekolah_sd' => 'SDN 1 Bandung',
                'sekolah_smp' => 'SMPN 2 Bandung',
                'sekolah_smk' => 'SMKN 1 Bandung',
                'tahun_lulus_sd' => '2016',
                'tahun_lulus_smp' => '2019',
                'pengalaman_kerja' => 'Magang di Telkom selama 6 bulan',
                'keterampilan' => 'Networking, Desain Grafis, Public Speaking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);        
    }
}

