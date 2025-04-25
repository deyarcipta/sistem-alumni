<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loker;
use Illuminate\Support\Facades\Storage;

class LokerController extends Controller
{
    public function index()
    {
        $items = Loker::with('perusahaan')->orderBy('tanggal_mulai','desc')->get();
        return view('admin.pages.loker.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_perusahaan'  => 'required|exists:daftar_perusahaan,id_perusahaan',
            'judul_loker'    => 'required|string|max:255',
            'foto'           => 'nullable|image|max:2048',
            'deskripsi'      => 'nullable|string',
            'tanggal_mulai'  => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'         => 'required|string|max:255',
        ]);

        $filename = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('loker','public');
            $filename = basename($path);
        }

        Loker::create([
            'id_perusahaan'   => $request->id_perusahaan,
            'judul_loker'     => $request->judul_loker,
            'foto'            => $filename,
            'deskripsi'       => $request->deskripsi,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_berakhir'=> $request->tanggal_berakhir,
            'lokasi'          => $request->lokasi,
        ]);

        return redirect()
            ->route('admin.loker.index')
            ->with('success','Data loker berhasil ditambahkan.');
    }

    public function update(Request $request, $id_loker)
    {
        $request->validate([
            'id_perusahaan'  => 'required|exists:daftar_perusahaan,id_perusahaan',
            'judul_loker'    => 'required|string|max:255',
            'foto'           => 'nullable|image|max:2048',
            'deskripsi'      => 'nullable|string',
            'tanggal_mulai'  => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'         => 'required|string|max:255',
        ]);

        $item = Loker::findOrFail($id_loker);

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                $old = 'loker/'.$item->foto;
                if (Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
            $path = $request->file('foto')->store('loker','public');
            $item->foto = basename($path);
        }

        $item->update($request->only([
            'id_perusahaan','judul_loker','deskripsi',
            'tanggal_mulai','tanggal_berakhir','lokasi'
        ]));

        return redirect()
            ->route('admin.loker.index')
            ->with('success','Data loker berhasil diperbarui.');
    }

    public function destroy($id_loker)
    {
        $item = Loker::findOrFail($id_loker);
        if ($item->foto) {
            $path = 'loker/'.$item->foto;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        $item->delete();

        return redirect()
            ->route('admin.loker.index')
            ->with('success','Data loker berhasil dihapus.');
    }
}
