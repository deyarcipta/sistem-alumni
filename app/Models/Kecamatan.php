<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan'; // Sesuaikan jika nama tabel bukan 'kecamatan'

    protected $fillable = [
        'nama', // kolom-kolom lain jika ada
    ];
}
