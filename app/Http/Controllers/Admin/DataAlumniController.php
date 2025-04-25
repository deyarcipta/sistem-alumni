<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Alumni;
use App\Models\Jurusan;
use App\Imports\AlumniImport;

class DataAlumniController extends Controller
{
    public function index(Request $request)
    {
        $jurusan = Jurusan::all(); 
        $years = Alumni::select('tahun_lulus')->distinct()->orderBy('tahun_lulus', 'desc')->pluck('tahun_lulus');

        $selectedYear = $request->input('tahun_lulus');
        $alumni = Alumni::when($selectedYear, function($query) use ($selectedYear) {
                return $query->where('tahun_lulus', $selectedYear);
            })
            ->orderBy('tahun_lulus', 'desc')
            ->get();

        return view('admin.pages.data_alumni.index', compact('alumni', 'jurusan', 'years', 'selectedYear'));
    }

    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('admin.alumni.show', compact('alumni'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:alumni,nis',
            'nisn' => 'nullable|string|max:50',
            'id_jurusan' => 'nullable|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:10',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100|unique:alumni,email',
            'tahun_lulus' => 'required|string|max:4',
            'sekolah_sd' => 'nullable|string|max:100',
            'tahun_lulus_sd' => 'nullable|string|max:4',
            'sekolah_smp' => 'nullable|string|max:100',
            'tahun_lulus_smp' => 'nullable|string|max:4',
            'sekolah_smk' => 'nullable|string|max:100',
            'pengalaman_kerja' => 'nullable|string',
            'keterampilan' => 'nullable|string',
        ]);
        // dd($validated['id_jurusan']);
        // Set default password dari tanggal lahir
        $validated['password'] = Hash::make($validated['tanggal_lahir']);
        $validated['foto'] = 'default.jpg';
        $validated['status'] = 'Bekerja';

        // Simpan ke database
        Alumni::create($validated);

        return redirect()->route('admin.alumni.index')->with('success', 'Alumni berhasil ditambahkan.');
    }

    public function update(Request $request, $id_alumni)
    {
        // dd($id_alumni);
        $alumni = Alumni::findOrFail($id_alumni);
        $alumni->update($request->all());
        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil diperbarui.');
    }

    public function resetPassword($id)
    {
        $alumni = Alumni::findOrFail($id);
        $tanggal = Carbon::parse($alumni->tanggal_lahir)->format('Y-m-d');
        $alumni->password = Hash::make($tanggal);
        $alumni->save();

        return redirect()->back()->with('resetSuccess', 'Password berhasil di-reset sesuai tanggal lahir.');
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        if ($alumni->foto && $alumni->foto !== 'default.jpg') {
            Storage::disk('public')->delete('foto_alumni/'.$alumni->foto);
        }
        $alumni->delete();
        return redirect()->route('admin.alumni.index')->with('success', 'Data alumni berhasil dihapus.');
    }

    public function showImportForm()
    {
        return view('admin.pages.data_alumni.import'); // Buat file ini nanti
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        try {
            Excel::import(new AlumniImport, $request->file('file'));
            return redirect()->route('admin.data-alumni.import.form')->with('success', 'Data alumni berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}
