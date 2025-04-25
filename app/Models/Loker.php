<?php

// app/Models/Loker.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DaftarPerusahaan;

class Loker extends Model
{
    use HasFactory;
    protected $table = 'loker';
    protected $primaryKey = 'id_loker';
    protected $fillable = ['id_perusahaan', 'judul_loker', 'foto', 'deskripsi', 'tanggal_mulai', 'tanggal_berakhir', 'lokasi'];

    public function perusahaan()
    {
        return $this->belongsTo(DaftarPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
