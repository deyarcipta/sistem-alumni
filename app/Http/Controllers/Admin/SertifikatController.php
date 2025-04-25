<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SertifikatAlumni;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Imports\SertifikatImport;

class SertifikatController extends Controller
{
    public function index()
    {
        $sertifikat = SertifikatAlumni::with('alumni')->get();
        return view('admin.pages.sertifikat.index', compact('sertifikat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alumni' => 'required',
            'file' => 'required|mimes:pdf,jpeg,png|max:10240',
        ]);

        $filename = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('sertifikat','public');
            $filename = basename($path);
        }

        SertifikatAlumni::create([
            'id_alumni' => $request->id_alumni,
            'nama_sertifikat' => $request->nama_sertifikat,
            'tanggal_diterbitkan' => $request->tanggal_diterbitkan,
            'file_path' => $filename,
        ]);

        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $sertifikat = SertifikatAlumni::findOrFail($id);
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('sertifikat');
            $sertifikat->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sertifikat = SertifikatAlumni::findOrFail($id);
        if ($sertifikat->file_path) {
            Storage::disk('public')->delete('sertifikat/'.$sertifikat->file_path);
        }
        $sertifikat->delete();

        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new SertifikatImport, $request->file('file'));
            return redirect()->route('admin.sertifikat.index')->with('success', 'Data sertifikat berhasil diimport.');
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
            $zipPath = $request->file('zip_file')->storeAs('temp', 'sertifikat_upload.zip');
            $realPath = storage_path("app/{$zipPath}");

            if ($zip->open($realPath) === TRUE) {
                // Menentukan folder ekstraksi
                $extractPath = storage_path('app/public/sertifikat');
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
                        $alumni = Alumni::whereHas('sertifikatAlumni', function($query) use ($fileNameWithoutExtension) {
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
