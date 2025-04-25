<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        // asumsikan hanya satu baris
        $setting = Setting::first();
        return view('admin.pages.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah'      => 'required|string|max:255',
            'singkatan_sekolah' => 'required|string|max:50',
            'logo'              => 'nullable|image|max:2048',
            'no_wa_bkk'         => 'nullable|string|max:20',
            'nama_bkk'          => 'nullable|string|max:100',
            'email_bkk'         => 'nullable|email|max:255',
            'bank'              => 'nullable|string|max:255',
            'nomor_rekening'    => 'nullable|string|max:255',
            'atas_nama'         => 'nullable|string|max:255',
            'alamat_sekolah'    => 'nullable|string',
        ]);

        $setting = Setting::first();

        // handle logo upload
        if ($request->hasFile('logo')) {
            // hapus lama
            if ($setting->logo && Storage::disk('public')->exists('settings/'.$setting->logo)) {
                Storage::disk('public')->delete('settings/'.$setting->logo);
            }
            $path = $request->file('logo')->store('settings','public');
            $setting->logo = basename($path);
        }

        // update field lain
        $setting->fill($request->only([
            'nama_sekolah',
            'singkatan_sekolah',
            'no_wa_bkk',
            'nama_bkk',
            'email_bkk',
            'bank',	
            'nomor_rekening',
            'atas_nama',
            'alamat_sekolah',
        ]));

        $setting->save();

        return redirect()
            ->route('admin.settings.edit')
            ->with('success','Pengaturan berhasil diperbarui.');
    }
}
