<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TagihanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari alumni berdasarkan nis dari Excel
        $alumni = Alumni::where('nis', $row['nis'])->first();

        // Jika alumni ditemukan, buat dokumen baru
        if ($alumni) {
            return new Tagihan([
                'id_alumni' => $alumni->id_alumni,
                'nominal' => $row['nominal'], // gunakan nominal dari Excel
                'status' => 'belum_bayar', 
            ]);
        }

        // Kalau tidak ketemu, bisa return null atau abaikan
        return null;
    }
}
