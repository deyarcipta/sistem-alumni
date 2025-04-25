<?php

// app/Models/DaftarPerusahaan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPerusahaan extends Model
{
    use HasFactory;
    protected $table = 'daftar_perusahaan';
    protected $primaryKey = 'id_perusahaan';
    protected $fillable = ['nama_perusahaan', 'alamat', 'telepon', 'website', 'foto_perusahaan', 'bidang_perusahaan'];

    public function lokers()
    {
        return $this->hasMany(Loker::class);
    }
}
