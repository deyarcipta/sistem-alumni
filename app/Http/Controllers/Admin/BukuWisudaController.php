<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuWisuda;
use Illuminate\Support\Facades\Storage;

class BukuWisudaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = BukuWisuda::orderBy('tahun', 'desc')->get();
        return view('admin.pages.buku_wisuda.index', compact('buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun'     => 'required|integer',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file'      => 'required|file|mimes:zip|max:20240',
        ]);

        // simpan file ZIP di storage/app/public/buku_wisuda
        $path = $request->file('file')->store('buku_wisuda', 'public');

        // Ambil hanya nama filenya
        $filename = basename($path);

        BukuWisuda::create([
            'tahun'     => $request->tahun,
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file'      => $filename,
        ]);

        return redirect()
            ->route('admin.bukuWisuda.index')
            ->with('success', 'Buku Wisuda berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_buku_wisuda)
    {
        $request->validate([
            'tahun'     => 'required|integer',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file'      => 'nullable|file|mimes:zip|max:10240',
        ]);

        $buku = BukuWisuda::findOrFail($id_buku_wisuda);
        $buku->tahun     = $request->tahun;
        $buku->judul     = $request->judul;
        $buku->deskripsi = $request->deskripsi;

        if ($request->hasFile('file')) {
            // hapus file lama jika ada
            if ($buku->file && Storage::disk('public')->exists($buku->file)) {
                Storage::disk('public')->delete($buku->file);
            }
            // simpan file baru
            $path = $request->file('file')->store('buku_wisuda', 'public');
            // Ambil hanya nama filenya
            $filename = basename($path);
            $buku->file = $filename;
        }

        $buku->save();

        return redirect()
            ->route('admin.bukuWisuda.index')
            ->with('success', 'Data Buku Wisuda berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_buku_wisuda)
    {
        $buku = BukuWisuda::findOrFail($id_buku_wisuda);

        // bangun path lengkap: folder + nama file
        $path = 'buku_wisuda/' . $buku->file;

        // hapus file dari storage/app/public/buku_wisuda/…
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $buku->delete();

        return redirect()
            ->route('admin.bukuWisuda.index')
            ->with('success', 'Data Buku Wisuda berhasil dihapus.');
    }
}
