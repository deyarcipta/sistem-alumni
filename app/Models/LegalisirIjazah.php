<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalisirIjazah extends Model
{
    protected $table = 'legalisir_ijazah';
    protected $fillable = [
        'id_alumni', 'email', 'telepon',
        'provinsi_id', 'kota_id', 'kecamatan_id', 'kelurahan_id',
        'nama_jalan', 'rt', 'rw', 'nomor_rumah', 'kode_pos',
        'jasa_kirim', 'biaya_pengiriman', 'status', 'status_pembayaran','bukti_pembayaran'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }
    
}
