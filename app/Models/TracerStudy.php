<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        // Step 1 - Verifikasi Data
        'nis', 'nisn', 'nama_siswa', 'jurusan', 'tahun_lulus', 'nama_lengkap', 
        'email', 'nomor_wa', 'nik', 'npwp',

        // Step 2 - Kuisioner Sekolah
        'pembelajaran', 'praktek', 'sarpras', 'pkl', 'biaya',

        // Step 3 - Kuisioner Dunia Kerja
        'mencari_pekerjaan', 'proses_mencari_kerja', 'jml_perusahaan', 
        'respon_perusahaan', 'undangan_perusahaan', 'status_kerja',

        // Step 4 - Data Diri
        'status_pekerjaan_sebelum_lulus', 'durasi_pekerjaan', 'pekerjaan', 
        'perusahaan', 'posisi_pekerjaan', 'tahun_masuk_pekerjaan', 'gaji',
        'etika', 'bahasa_inggris', 'komunikasi', 'kerja_sama', 
        'pengembangan_diri', 'saran'

    ];
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'nis', 'nis');
    }
}
