<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    protected $fillable = ['id_alumni', 'nominal', 'bukti_pembayaran', 'status'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
