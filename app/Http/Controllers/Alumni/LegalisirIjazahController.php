<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini!
use Illuminate\Support\Facades\Auth;
use App\Models\LegalisirIjazah;
use Carbon\Carbon;


class LegalisirIjazahController extends Controller
{
    public function create()
    {
        $alumni = auth()->guard('alumni')->user();
        $provinsi = DB::table('provinsi')->get();

        return view('alumni.pages.legalisir.index', compact('alumni', 'provinsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'telepon' => 'required',
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'nama_jalan' => 'required',
            'kode_pos' => 'required',
            'jasa_kirim' => 'required',
        ]);
        // Ambil data alumni yang sedang login
        $alumni = auth()->guard('alumni')->user();

        // Pastikan alumni sudah login dan memiliki id_alumni
        if (!$alumni) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        LegalisirIjazah::create([
            'id_alumni' => $alumni->id_alumni,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'provinsi_id' => $request->provinsi_id,
            'kota_id' => $request->kota_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'nama_jalan' => $request->nama_jalan,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'nomor_rumah' => $request->nomor_rumah,
            'kode_pos' => $request->kode_pos,
            'jasa_kirim' => $request->jasa_kirim,
            'status' => 'pending', // Status awal
            'status_pembayaran' => 'belum bayar', // Status awal
            // 'biaya_pengiriman' => $request->biaya_pengiriman,
        ]);

        return redirect()->route('alumni.legalisir.logs')->with('success', 'Permohonan legalisir berhasil dikirim.');
    }

    public function showLogs()
    {
        $id_alumni = auth()->guard('alumni')->user()->id_alumni;
        // Mengambil data dari tabel legalisir_ijazah
        $legalisirLogs = LegalisirIjazah::where('id_alumni', $id_alumni)
                        ->orderBy('created_at', 'desc')
                        ->get(); // Atau bisa menggunakan `where` jika ada filter

        // Mengubah waktu 'created_at' menggunakan zona waktu Jakarta
        $legalisirLogs->transform(function ($log) {
            $log->created_at = Carbon::parse($log->created_at)->timezone('Asia/Jakarta');
            return $log;
        });

        return view('alumni.pages.legalisir.logs', compact('legalisirLogs'));
    }

    public function approve($id)
    {
        // Temukan pengajuan berdasarkan ID
        $legalisir = LegalisirIjazah::findOrFail($id);

        // Ubah status menjadi 'proses'
        $legalisir->status = 'proses';
        $legalisir->save();

        return redirect()->route('alumni.legalisir.logs')->with('success', 'Status pengajuan telah diubah menjadi Proses');
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $log = LegalisirIjazah::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('public/bukti_pembayaran', $filename);
            $log->bukti_pembayaran = $filename;
            $log->status_pembayaran = 'pengecekan'; // misalnya ubah status
            $log->save();
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function destroy($id)
    {
        $log = LegalisirIjazah::findOrFail($id);
        
        // Pastikan hanya bisa menghapus pengajuan dengan status tertentu, misalnya 'pending'
        if ($log->status != 'pending') {
            return redirect()->route('alumni.legalisir.logs')->with('error', 'Hanya pengajuan dengan status pending yang dapat dihapus.');
        }
        
        $log->delete();

        return redirect()->route('alumni.legalisir.logs')->with('success', 'Pengajuan berhasil dihapus.');
    }

}
