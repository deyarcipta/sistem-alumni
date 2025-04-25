<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\PengalamanKerja;
use App\Models\Alumni;
use App\Models\SertifikatAlumni;

class ProfileAlumniController extends Controller
{
    // Menampilkan profil alumni
    public function show()
    {
        // Ambil data profil alumni berdasarkan user yang sedang login
        $profileAlumni = auth()->user();

        // Pastikan data alumni ada
        if (!$profileAlumni) {
            return redirect()->route('alumni.dashboard.index')->with('error', 'Profil alumni tidak ditemukan.');
        }

        // Pastikan mengambil relasi pengalaman kerja
        $profileAlumni->load(['pengalamanKerja' => function ($query) {
            $query->orderByDesc('tahun_akhir');
            },
            'sertifikat' => function ($query) {
                $query->orderByDesc('created_at'); // misalnya mau urut terbaru dulu
            },
        ]);

        return view('alumni.pages.profile.index', compact('profileAlumni'));
    }

    // Menangani pembaruan foto alumni
    public function updateFoto(Request $request, $id_alumni)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $profileAlumni = Alumni::findOrFail($id_alumni);

         // Menghapus foto lama jika ada, kecuali default.jpg
        if (
            $profileAlumni->foto &&
            $profileAlumni->foto !== 'default.jpg' &&
            file_exists(storage_path('app/public/foto_alumni/' . $profileAlumni->foto))
        ) {
            unlink(storage_path('app/public/foto_alumni/' . $profileAlumni->foto));
        }

        // Upload foto baru
        $filename = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_alumni','public');
            $filename = basename($path);
        }

        // Menyimpan path foto ke database
        $profileAlumni->update(['foto' => $filename]);

        return redirect()->route('alumni.profile', $id_alumni)->with('success', 'Foto berhasil diperbarui!');
    }

    public function tambahPengalaman(Request $request)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'tahun_awal' => 'required|numeric',
            'tahun_akhir' => 'required|numeric|gte:tahun_awal',
        ]);

        // Ambil alumni yang sedang login
        $alumni = Auth::guard('alumni')->user(); // sesuaikan jika pakai guard khusus

        // Simpan pengalaman kerja
        $alumni->pengalamanKerja()->create([
            'id_alumni' => $alumni->id_alumni, // Asumsi id_alumni adalah kolom yang sesuai
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'tahun_awal' => $request->tahun_awal,
            'tahun_akhir' => $request->tahun_akhir,
        ]);

        return back()->with('success', 'Pengalaman kerja berhasil ditambahkan.');
    }

    public function hapusPengalaman($id_pengalaman_kerja)
    {
        $pengalaman = PengalamanKerja::where('id_pengalaman_kerja', $id_pengalaman_kerja)->firstOrFail();
        $pengalaman->delete();

        return back()->with('success', 'Pengalaman kerja berhasil dihapus.');
    }

    public function showChangePassword()
    {
        return view('alumni.pages.profile.ubah_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $alumni = Auth::guard('alumni')->user();

        if (!Hash::check($request->current_password, $alumni->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $alumni->password = Hash::make($request->new_password);
        $alumni->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
