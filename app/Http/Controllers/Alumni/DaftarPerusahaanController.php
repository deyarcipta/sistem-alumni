<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarPerusahaan;
use Illuminate\Support\Facades\Storage;

class DaftarPerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = DaftarPerusahaan::all();
        return view('alumni.pages.daftarPerusahaan.index', compact('perusahaan'));
    }
}
