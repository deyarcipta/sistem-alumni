<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengalamanKerja extends Model
{
    protected $table = 'pengalaman_kerja';
    // Menentukan primary key
    protected $primaryKey = 'id_pengalaman_kerja';
    protected $fillable = [
        'id_alumni', 'nama_pekerjaan', 'nama_perusahaan', 'tahun_awal', 'tahun_akhir',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}

