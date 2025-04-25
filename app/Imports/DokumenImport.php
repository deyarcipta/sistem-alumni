<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\DokumenAlumni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DokumenImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari alumni berdasarkan nis dari Excel
        $alumni = Alumni::where('nis', $row['nis'])->first();

        // Jika alumni ditemukan, buat dokumen baru
        if ($alumni) {
            return new DokumenAlumni([
                'id_alumni' => $alumni->id_alumni,
                'jenis_dokumen' => $row['jenis_dokumen'],
                'file_path' => $row['nama_file'], // gunakan nama_file dari Excel
            ]);
        }

        // Kalau tidak ketemu, bisa return null atau abaikan
        return null;
    }
}
