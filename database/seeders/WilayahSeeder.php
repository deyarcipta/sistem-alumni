<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/csv/full.csv');
        if (!File::exists($path)) {
            $this->command->error("File full.csv tidak ditemukan.");
            return;
        }

        $csv = array_map('str_getcsv', file($path));
        $header = array_map('trim', array_shift($csv)); // ambil header

        // ID mapping agar auto-increment berjalan
        $provinsi = [];
        $kota = [];
        $kecamatan = [];

        foreach ($csv as $row) {
            $data = array_combine($header, $row);

            // Insert Provinsi
            if (!isset($provinsi[$data['prov_name']])) {
                $prov_id = DB::table('provinsi')->insertGetId([
                    'nama' => $data['prov_name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $provinsi[$data['prov_name']] = $prov_id;
            }

            // Insert Kota
            if (!isset($kota[$data['city_name']])) {
                $kota_id = DB::table('kota')->insertGetId([
                    'provinsi_id' => $provinsi[$data['prov_name']],
                    'nama' => $data['city_name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $kota[$data['city_name']] = $kota_id;
            }

            // Insert Kecamatan
            if (!isset($kecamatan[$data['dis_name']])) {
                $kec_id = DB::table('kecamatan')->insertGetId([
                    'kota_id' => $kota[$data['city_name']],
                    'nama' => $data['dis_name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $kecamatan[$data['dis_name']] = $kec_id;
            }

            // Insert Kelurahan
            DB::table('kelurahan')->insert([
                'kecamatan_id' => $kecamatan[$data['dis_name']],
                'nama' => $data['subdis_name'],
                'kode_pos' => $data['postal_code'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->command->info("✅ Data wilayah berhasil dimasukkan!");
    }
}
