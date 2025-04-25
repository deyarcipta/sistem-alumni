<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LegalisirIjazah;
use App\Models\Alumni;
use Illuminate\Support\Facades\Storage;

class LegalisirIjazahController extends Controller
{
    public function index()
    {
        $data = LegalisirIjazah::with('alumni')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('admin.pages.legalisir_ijazah.index', compact('data'));
    }

    public function show($id)
    {
        $item = LegalisirIjazah::with('alumni')->findOrFail($id);
        return view('admin.legalisir.show', compact('item'));
    }

    public function updateBiaya(Request $request, $id)
    {
        $request->validate([
            'biaya_pengiriman' => 'required|numeric|min:0',
        ]);

        $item = LegalisirIjazah::findOrFail($id);
        $item->biaya_pengiriman = $request->biaya_pengiriman;
        $item->save();

        return redirect()->route('admin.legalisir.index')
                         ->with('success', 'Biaya pengiriman berhasil diperbarui.');
    }

    public function prosesBayar(Request $request, $id)
    {
        $legalisir = LegalisirIjazah::findOrFail($id);
        $legalisir->status_pembayaran = 'sudah bayar';
        $legalisir->save();

        return redirect()->route('admin.legalisir.index')
                        ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function inputResi(Request $request, $id)
    {
        $request->validate([
            'resi' => 'required|string|max:255',
        ]);

        $legalisir = LegalisirIjazah::findOrFail($id);
        $legalisir->resi = $request->input('resi');
        // Jika ingin ubah status jadi 'dikirim' misalnya:
        $legalisir->status = 'dikirim'; 
        $legalisir->save();

        return redirect()
            ->route('admin.legalisir.index')
            ->with('success', 'Nomor resi berhasil disimpan.');
    }

    public function destroy($id)
    {
        $item = LegalisirIjazah::findOrFail($id);
        // jika ada file bukti pembayaran, hapus dari storage
        if ($item->bukti_pembayaran) {
            Storage::disk('public')->delete('bukti_pembayaran/'.$item->bukti_pembayaran);
        }
        $item->delete();

        return redirect()->route('admin.legalisir.index')
                         ->with('success', 'Data legalisir berhasil dihapus.');
    }
}
