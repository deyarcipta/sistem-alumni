<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun lulus yang dipilih dari form, atau jika tidak ada pilih tahun terbaru
        $tahunLulus = $request->input('tahun_lulus', Alumni::max('tahun_lulus')); // Ambil tahun terbaru jika tidak ada input

        // Ambil data alumni berdasarkan tahun lulus yang dipilih
        $alumni = Alumni::where('tahun_lulus', $tahunLulus)->get();

        // Ambil semua tahun lulus yang tersedia untuk dropdown
        $tahunLulusOptions = Alumni::distinct()->pluck('tahun_lulus');

        return view('alumni.pages.data_alumni.index', compact('alumni', 'tahunLulus', 'tahunLulusOptions'));
    }

}
