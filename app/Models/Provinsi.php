<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi'; // Sesuaikan jika nama tabel bukan 'provinsi'

    protected $fillable = [
        'nama', // kolom-kolom lain jika ada
    ];
}
