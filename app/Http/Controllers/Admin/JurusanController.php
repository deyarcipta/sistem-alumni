<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JurusanImport;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('admin.pages.jurusan.index', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'singkatan_jurusan' => 'required',
            'nama_jurusan' => 'required'
        ]);

        Jurusan::create($request->all());
        return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($request->all());
        return redirect()->back()->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jurusan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jurusan berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new JurusanImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data jurusan berhasil diimport.');
    }
}
