<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BukuWisuda;
use App\Models\Alumni;

class BukuWisudaController extends Controller
{
    public function index()
    {
        // Ambil data alumni yang sedang login
    $alumni = Auth::guard('alumni')->user();

    // Ambil tahun kelulusan alumni
    $tahunLulus = $alumni->tahun_lulus;

    // Ambil buku wisuda berdasarkan tahun
    $bukuWisuda = BukuWisuda::where('tahun', $tahunLulus)->get();

    return view('alumni.pages.buku_wisuda.index', compact('bukuWisuda', 'tahunLulus'));
    }

    public function download($id)
    {
        $buku = BukuWisuda::findOrFail($id);
        return response()->download(public_path('storage/buku_wisuda/' . $buku->file));
    }
}
