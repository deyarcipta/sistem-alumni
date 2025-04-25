<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'singkatan_sekolah',
        'logo',
        'no_wa_bkk',
        'nama_bkk',
        'email_bkk',
        'bank',
        'nomor_rekening',
        'atas_nama',
        'alamat_sekolah',
    ];
}
