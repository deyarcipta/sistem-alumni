<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumni extends Authenticatable
{
    protected $primaryKey = 'id_alumni';
    protected $table = 'alumni'; 
    protected $guard = 'alumni';
    protected $fillable = ['nama', 'nis', 'nisn','id_jurusan', 'password', 'foto', 'status', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 
        'status_pernikahan', 'alamat', 'no_hp', 'email', 'tahun_lulus', 'sekolah_sd', 
        'tahun_lulus_sd', 'sekolah_smp', 'tahun_lulus_smp', 'sekolah_smk', 'pengalaman_kerja', 
        'keterampilan'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function dokumenAlumni()
    {
        return $this->hasMany(DokumenAlumni::class, 'id_alumni', 'id_alumni');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_alumni', 'id_alumni');
    }

    public function pengalamanKerja()
    {
        return $this->hasMany(PengalamanKerja::class, 'id_alumni', 'id_alumni');
    }

    public function sertifikat()
    {
        return $this->hasMany(SertifikatAlumni::class, 'id_alumni', 'id_alumni');
    }
    
}
