<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\SertifikatAlumni;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SertifikatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Importing row: ', $row);

        // Deteksi dan format tanggal
        if (is_numeric($row['tanggal_terbit'])) {
            $tanggalTerbit = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_terbit'])->format('Y-m-d');
        } else {
            try {
                $tanggalTerbit = Carbon::createFromFormat('d-m-Y', $row['tanggal_terbit'])->format('Y-m-d');
            } catch (\Exception $e1) {
                try {
                    $tanggalTerbit = Carbon::createFromFormat('d/m/Y', $row['tanggal_terbit'])->format('Y-m-d');
                } catch (\Exception $e2) {
                    Log::warning('Gagal parse tanggal: ' . $row['tanggal_terbit']);
                    return null;
                }
            }
        }

        // Temukan alumni
        $alumni = Alumni::where('nis', $row['nis'])->first();

        if (!$alumni) {
            Log::warning('Alumni tidak ditemukan untuk NIS: ' . $row['nis']);
            return null;
        }

        // Simpan sertifikat
        $sertifikat = new SertifikatAlumni([
            'id_alumni' => $alumni->id_alumni,
            'nama_sertifikat' => $row['nama_sertifikat'] ?? null,
            'tanggal_diterbitkan' => $tanggalTerbit,
            'file_path' => $row['nama_file'],
        ]);

        Log::info('Sertifikat disimpan: ', $sertifikat->toArray());
        return $sertifikat;
    }
}
