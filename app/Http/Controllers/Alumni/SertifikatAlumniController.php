<?php

namespace App\Http\Controllers\Alumni;

use App\Models\SertifikatAlumni;
use App\Models\Tagihan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatAlumniController extends Controller
{
    public function index()
    {
        $alumni = auth()->user();  // Mengambil data alumni yang sedang login
        // Memeriksa apakah alumni memiliki tagihan yang belum dibayar berdasarkan id_alumni
        $tagihan = Tagihan::where('id_alumni', $alumni->id_alumni) // Asumsi id_alumni adalah kolom yang sesuai
                        ->where('status', 'belum_bayar')
                        ->first(); // Mengambil tagihan yang pertama kali ditemukan
                        
        // Ambil data dokumen alumni
        $sertifikat = SertifikatAlumni::where('id_alumni', $alumni->id_alumni)
                        ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal terbaru
                        ->get();
        return view('alumni.pages.sertifikat.index', compact('tagihan','sertifikat'));
    }

    public function download($id)
    {
        $sertifikat = SertifikatAlumni::findOrFail($id);
        return Storage::download('public/sertifikat/'.$sertifikat->file_path);
    }
}
