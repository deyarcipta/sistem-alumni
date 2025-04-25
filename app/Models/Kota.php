<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'kota'; // Sesuaikan jika nama tabel bukan 'kota'

    protected $fillable = [
        'nama', // kolom-kolom lain jika ada
    ];
}
