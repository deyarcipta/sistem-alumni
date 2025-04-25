<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\DokumenAlumni;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenAlumniController extends Controller
{
    public function index()
    {
        $alumni = auth()->user();  // Mengambil data alumni yang sedang login
        // Memeriksa apakah alumni memiliki tagihan yang belum dibayar berdasarkan id_alumni
        $tagihan = Tagihan::where('id_alumni', $alumni->id_alumni) // Asumsi id_alumni adalah kolom yang sesuai
                        ->whereIn('status', ['belum_bayar', 'proses']) // Mengambil tagihan yang statusnya bukan batal
                        ->first(); // Mengambil tagihan yang pertama kali ditemukan
                        
        // Ambil data dokumen alumni
        $dokumen = DokumenAlumni::where('id_alumni', $alumni->id_alumni)
                    ->orderByRaw("CASE WHEN jenis_dokumen = 'Ijazah' THEN 1 ELSE 2 END")
                    ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal terbaru setelahnya
                    ->get();

        // Kirim data ke view
        return view('alumni.pages.dokumen.index', compact('dokumen', 'tagihan'));
    }



    public function download($id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);
        return Storage::download('public/dokumen/'.$dokumen->file_path);
    }
}
