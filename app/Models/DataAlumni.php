<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAlumni extends Model
{
    use HasFactory;

    protected $table = 'data_alumni';
    protected $primaryKey = 'id_data_alumni';

    protected $fillable = [
        'id_alumni',
        'nama',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'no_hp',
        'email',
        'jenis_kelamin',
        'agama',
        'status_pernikahan',
        'kewargaan',
        'sekolah_sd',
        'sekolah_smp',
        'sekolah_smk',
        'tahun_lulus_sd',
        'tahun_lulus_smp',
        'tahun_lulus_smk',
        'pengalaman_kerja',
        'keterampilan',
    ];

    /**
     * Relasi ke model Alumni
     */
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}

