<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TagihanAlumniController extends Controller
{
    /**
     * Tampilkan daftar tagihan untuk alumni yang sedang login.
     */
    public function index()
    {
        $alumniId = Auth::user()->id_alumni;
        // ambil tagihan, termasuk file bukti jika ada
        $tagihan = Tagihan::where('id_alumni', $alumniId)
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('alumni.pages.tagihan.index', compact('tagihan'));
    }

    /**
     * Proses upload bukti pembayaran: simpan file ke storage,
     * kemudian update kolom file_bukti dan status jadi 'sudah_bayar'.
     */
    public function bayar(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $alumniId = Auth::user()->id_alumni;
        $tagihan = Tagihan::where('id_tagihan', $id)
                          ->where('id_alumni', $alumniId)
                          ->firstOrFail();

         // Simpan file, $storedPath = "bukti_tagihan/abcdef12345.jpg"
        $storedPath = $request->file('bukti')->store('bukti_tagihan', 'public');

        // Ambil hanya nama filenya
        $filename = basename($storedPath);

        // Update kolom file_bukti dan status
        $tagihan->bukti_pembayaran = $filename;
        $tagihan->status     = 'proses';
        $tagihan->save();

        return redirect()->route('alumni.tagihan.index')
                         ->with('success', 'Bukti pembayaran berhasil diunggah dan tagihan telah dibayar.');
    }
}
