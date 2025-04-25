<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahan'; // Sesuaikan jika nama tabel bukan 'kelurahan'

    protected $fillable = [
        'nama', // kolom-kolom lain jika ada
    ];
}
