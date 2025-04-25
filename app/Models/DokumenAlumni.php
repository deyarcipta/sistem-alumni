<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenAlumni extends Model
{
    use HasFactory;

    protected $table = 'dokumen_alumni';
    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'id_alumni',
        'jenis_dokumen',
        'file_path',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
