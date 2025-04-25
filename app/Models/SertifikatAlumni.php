<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatAlumni extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';
    protected $primaryKey = 'id_sertifikat';

    protected $fillable = [
        'id_alumni',
        'nama_sertifikat',
        'tanggal_diterbitkan',
        'file_path',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
