<?php

namespace Database\Seeders;

use App\Models\Tagihan;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    public function run()
    {

            Tagihan::create([
                'id_alumni' => '2', // ID alumni yang sesuai
                'nominal' => 5000000, // Contoh nominal tagihan
                'status' => 'belum_bayar', // Status belum dibayar
            ]);
    }
}
