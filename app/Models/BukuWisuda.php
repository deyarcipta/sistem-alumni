<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuWisuda extends Model
{
    protected $table = 'buku_wisuda';
    protected $primaryKey = 'id_buku_wisuda';

    protected $fillable = [
        'tahun', 'judul', 'deskripsi', 'file'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
