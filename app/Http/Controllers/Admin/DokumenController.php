<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenAlumni;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Imports\DokumenImport;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumenAlumni = DokumenAlumni::where('jenis_dokumen', '!=', 'Ijazah')->get();
        return view('admin.pages.dokumen_alumni.index', compact('dokumenAlumni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'jenis_dokumen' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('dokumen','public');
            $filename = basename($path);
        }

        DokumenAlumni::create([
            'id_alumni' => $request->id_alumni,
            'jenis_dokumen' => $request->jenis_dokumen,
            'file_path' => $filename,
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);

        $request->validate([
            'jenis_dokumen' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file')) {
            if ($dokumen->file_path) {
                $old = 'dokumen/'.$dokumen->file_path;
                if (Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
            $path = $request->file('file')->store('dokumen_alumni','public');
            $dokumen->file_path = basename($path);
        }

        $dokumen->save();

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);

        if ($dokumen->file_path) {
            Storage::disk('public')->delete('dokumen/'.$dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DokumenImport, $request->file('file'));
            return redirect()->route('admin.dokumen.index')->with('success', 'Data dokumen berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function uploadZip(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|mimes:zip',
        ]);

        try {
            $zip = new ZipArchive;
            // Menyimpan file zip yang diupload
            $zipPath = $request->file('zip_file')->storeAs('temp', 'dokumen_upload.zip');
            $realPath = storage_path("app/{$zipPath}");

            if ($zip->open($realPath) === TRUE) {
                // Menentukan folder ekstraksi
                $extractPath = storage_path('app/public/dokumen');
                if (!is_dir($extractPath)) {
                    mkdir($extractPath, 0775, true); // Membuat folder jika belum ada
                }

                $zip->extractTo($extractPath);
                $zip->close();

                // Mengambil daftar file di dalam folder ekstraksi
                $files = scandir($extractPath);
                foreach ($files as $file) {
                    // Memeriksa apakah file yang ditemukan memiliki ekstensi PDF
                    if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                        $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);

                        // Mencocokkan dengan id_alumni berdasarkan file_name pada file_path
                        $alumni = Alumni::whereHas('dokumenAlumni', function($query) use ($fileNameWithoutExtension) {
                            $query->where('file_path', 'like', "%{$fileNameWithoutExtension}%");
                        })->first();

                    }
                }

                return redirect()->back()->with('success', 'File ZIP berhasil diupload dan diproses.');
            } else {
                return redirect()->back()->with('error', 'Gagal membuka file ZIP. Pastikan format file ZIP valid.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
