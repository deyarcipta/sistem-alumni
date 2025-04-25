<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarPerusahaan;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function index()
    {
        $items = DaftarPerusahaan::orderBy('created_at', 'desc')->get();
        return view('admin.pages.daftar_perusahaan.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan'   => 'required|string|max:255',
            'alamat'            => 'required|string',
            'telepon'           => 'required|string|max:50',
            'website'           => 'nullable|url|max:255',
            'foto_perusahaan'   => 'nullable|image|max:2048',
            'bidang_perusahaan' => 'nullable|string|max:255',
        ]);

        $filename = null;
        if ($request->hasFile('foto_perusahaan')) {
            // simpan file di storage/app/public/perusahaan_wisuda
            $storedPath = $request->file('foto_perusahaan')
                                  ->store('daftar_perusahaan', 'public');

            // ambil hanya nama file
            $filename = basename($storedPath);
        }

        DaftarPerusahaan::create([
            'nama_perusahaan'   => $request->nama_perusahaan,
            'alamat'            => $request->alamat,
            'telepon'           => $request->telepon,
            'website'           => $request->website,
            'foto_perusahaan'   => $filename,
            'bidang_perusahaan' => $request->bidang_perusahaan,
        ]);

        return redirect()
            ->route('admin.perusahaan.index')
            ->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function update(Request $request, $id_perusahaan)
    {
        $request->validate([
            'nama_perusahaan'   => 'required|string|max:255',
            'alamat'            => 'required|string',
            'telepon'           => 'required|string|max:50',
            'website'           => 'nullable|url|max:255',
            'foto_perusahaan'   => 'nullable|image|max:2048',
            'bidang_perusahaan' => 'nullable|string|max:255',
        ]);

        $item = DaftarPerusahaan::findOrFail($id_perusahaan);

        if ($request->hasFile('foto_perusahaan')) {
            // hapus file lama jika ada
            if ($item->foto_perusahaan) {
                $oldPath = 'daftar_perusahaan/' . $item->foto_perusahaan;
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // simpan file baru
            $storedPath = $request->file('foto_perusahaan')
                                  ->store('daftar_perusahaan', 'public');
            $item->foto_perusahaan = basename($storedPath);
        }

        // update kolom lainnya
        $item->update($request->only([
            'nama_perusahaan',
            'alamat',
            'telepon',
            'website',
            'bidang_perusahaan',
        ]));

        return redirect()
            ->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy($id_perusahaan)
    {
        $item = DaftarPerusahaan::findOrFail($id_perusahaan);

        // hapus file jika ada
        if ($item->foto_perusahaan) {
            $path = 'daftar_perusahaan/' . $item->foto_perusahaan;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $item->delete();

        return redirect()
            ->route('admin.perusahaan.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}
