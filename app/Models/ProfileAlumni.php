<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileAlumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'jurusan', 'tanggal_lahir', 'foto', 
    ];

    // Relasi dengan pendidikan alumni

}
