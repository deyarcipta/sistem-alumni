<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\DokumenAlumni;
use App\Models\Alumni;
use App\Imports\IjazahImport;

class IjazahController extends Controller
{
    public function index()
    {
        $ijazah = DokumenAlumni::where('jenis_dokumen', 'Ijazah')->with('alumni')->get();
        return view('admin.pages.ijazah.index', compact('ijazah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $filename = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('dokumen','public');
            $filename = basename($path);
        }

        DokumenAlumni::create([
            'id_alumni' => $request->id_alumni,
            'jenis_dokumen' => 'Ijazah',
            'file_path' => $filename,
        ]);

        return back()->with('success', 'Data ijazah berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);

        if ($request->hasFile('file')) {
            if ($dokumen->file_path) {
                $old = 'dokumen/'.$dokumen->file_path;
                if (Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
            $path = $request->file('file')->store('ijazah','public');
            $dokumen->file_path = basename($path);
        }

        $dokumen->save();
        return back()->with('success', 'Data ijazah berhasil diupdate.');
    }

    public function destroy($id)
    {
        $dokumen = DokumenAlumni::findOrFail($id);
        if ($dokumen->file_path) {
            Storage::disk('public')->delete('dokumen/'.$dokumen->file_path);
        }
        $dokumen->delete();
        return back()->with('success', 'Data ijazah berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new IjazahImport, $request->file('file'));
            return redirect()->route('admin.ijazah.index')->with('success', 'Data ijazah berhasil diimport.');
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
            $zipPath = $request->file('zip_file')->storeAs('temp', 'ijazah_upload.zip');
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

                        // Jika ditemukan alumni berdasarkan file_name pada file_path
                        if ($alumni) {
                            // Jika sudah ada dokumen, lakukan update atau create
                            DokumenAlumni::updateOrCreate(
                                ['id_alumni' => $alumni->id_alumni, 'jenis_dokumen' => 'Ijazah'],
                                ['file_path' => $file]
                            );
                        }
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
