<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Tagihan;
use App\Models\Alumni;
use App\Imports\TagihanImport;


class TagihanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua tagihan, bisa ditambahkan filter jika perlu
        $tagihan = Tagihan::orderBy('created_at', 'desc')
                          ->with('alumni') // Mengambil data alumni terkait
                          ->get();
        // Ambil daftar alumni untuk dropdown tambah/edit
        $alumniList = Alumni::orderBy('nama')->get();

        return view('admin.pages.tagihan.index', compact('tagihan', 'alumniList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'nominal'   => 'required|numeric|min:0',
            'status'    => 'required|in:belum_bayar,sudah_bayar',
        ]);

        Tagihan::create($request->only('id_alumni','nominal','status'));

        return redirect()->route('admin.tagihan.index')
                         ->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'nominal'   => 'required|numeric|min:0',
            'status'    => 'required|in:pending,lunas',
        ]);

        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update($request->only('id_alumni','nominal','status'));

        return redirect()->route('admin.tagihan.index')
                         ->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        if ($tagihan->bukti_pembayaran) {
            Storage::disk('public')->delete('bukti_tagihan/'.$tagihan->bukti_pembayaran);
        }
        $tagihan->delete();

        return redirect()->route('admin.tagihan.index')
                         ->with('success', 'Tagihan berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new TagihanImport, $request->file('file'));
            return redirect()->route('admin.tagihan.index')->with('success', 'Data tagihan berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function verify(Request $request, $id)
    {
        // Cari tagihan
        $tagihan = Tagihan::findOrFail($id);

        // Jika belum ada bukti atau status bukan proses, tolak
        if (! $tagihan->bukti_pembayaran || $tagihan->status !== 'proses') {
            return redirect()->back()->with('error', 'Tagihan tidak dalam status proses atau belum ada bukti.');
        }

        // Ubah status
        $tagihan->status = 'sudah_dibayar';
        $tagihan->save();

        return redirect()->back()->with('success', 'Tagihan telah diverifikasi dan status diubah menjadi sudah bayar.');
    }
}
