<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan semua field yang harusnya string, dicasting jadi string
        $row['nis'] = (string) $row['nis'];
        $row['email'] = isset($row['email']) ? (string) $row['email'] : null;

        // Ambil ID jurusan berdasarkan singkatan
        $idJurusan = \App\Models\Jurusan::where('singkatan_jurusan', $row['id_jurusan'])->value('id_jurusan');
        if (!$idJurusan) {
            throw new \Exception("Jurusan dengan singkatan '{$row['id_jurusan']}' tidak ditemukan.");
        }

        if (is_numeric($row['tanggal_lahir'])) {
            // Format dari Excel (tanggal sebagai serial number)
            $tanggalLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
        } else {
            // Format sebagai string, coba parsing manual
            try {
                $tanggalLahir = Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir'])->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    $tanggalLahir = Carbon::createFromFormat('d/m/Y', $row['tanggal_lahir'])->format('Y-m-d');
                } catch (\Exception $e) {
                    throw new \Exception('Format tanggal lahir tidak dikenali: ' . $row['tanggal_lahir']);
                }
            }
        }

        Validator::make($row, [
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:alumni,nis',
            'email' => 'nullable|email|max:100|unique:alumni,email',
        ])->validate();

        return new \App\Models\Alumni([
            'nama' => $row['nama'],
            'nis' => $row['nis'],
            'nisn' => $row['nisn'] ?? null,
            'id_jurusan' => $idJurusan,
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $row['jenis_kelamin'],
            'agama' => $row['agama'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'email' => $row['email'] ?? null,
            'tahun_lulus' => $row['tahun_lulus'],
            'sekolah_sd' => $row['sekolah_sd'] ?? null,
            'tahun_lulus_sd' => $row['tahun_lulus_sd'] ?? null,
            'sekolah_smp' => $row['sekolah_smp'] ?? null,
            'tahun_lulus_smp' => $row['tahun_lulus_smp'] ?? null,
            'sekolah_smk' => $row['sekolah_smk'] ?? null,
            'pengalaman_kerja' => $row['pengalaman_kerja'] ?? null,
            'keterampilan' => $row['keterampilan'] ?? null,
            'password' => bcrypt($tanggalLahir), // password dari tanggal lahir
            'foto' => 'default.jpg',
            'status' => '-',
        ]);
    }
}
