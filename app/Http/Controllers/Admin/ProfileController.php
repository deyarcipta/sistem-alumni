<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class ProfileController extends Controller
{
    public function show()
    {
        // Ambil data profil alumni berdasarkan user yang sedang login
        $profileAdmin = auth()->user();
        return view('admin.pages.profile.index', compact('profileAdmin'));
    }

    public function updateFoto(Request $request, $id)
    {
        
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $profile = Admin::findOrFail($id);

         // Menghapus foto lama jika ada, kecuali default.jpg
        if (
            $profile->foto &&
            $profile->foto !== 'default.jpg' &&
            file_exists(storage_path('app/public/foto_admin/' . $profile->foto))
        ) {
            unlink(storage_path('app/public/foto_admin/' . $profile->foto));
        }

        // Upload foto baru
        $filename = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_admin','public');
            $filename = basename($path);
        }

        // Menyimpan path foto ke database
        $profile->update(['foto' => $filename]);

        return redirect()->route('admin.profile', $id)->with('success', 'Foto berhasil diperbarui!');
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->nama = $request->nama;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }

}
