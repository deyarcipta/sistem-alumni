<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LokerSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ID perusahaan ada. Misal ID 1 sudah ada.
        DB::table('loker')->insert([
            [
                'id_perusahaan'   => 1,
                'judul_loker'     => 'Frontend Developer',
                'foto'            => 'uploads/loker/frontend.png',
                'deskripsi'       => 'Bertanggung jawab atas tampilan UI/UX aplikasi web.',
                'tanggal_mulai'   => Carbon::now()->toDateString(),
                'tanggal_berakhir'=> Carbon::now()->addWeeks(2)->toDateString(),
                'lokasi'          => 'Jakarta',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'id_perusahaan'   => 1,
                'judul_loker'     => 'Backend Developer',
                'foto'            => 'uploads/loker/backend.png',
                'deskripsi'       => 'Mengembangkan dan mengelola API dan logic bisnis aplikasi.',
                'tanggal_mulai'   => Carbon::now()->toDateString(),
                'tanggal_berakhir'=> Carbon::now()->addWeeks(3)->toDateString(),
                'lokasi'          => 'Bandung',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
