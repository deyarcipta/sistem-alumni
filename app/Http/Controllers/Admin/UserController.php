<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $users = Admin::orderBy('id')->get();
        return view('admin.pages.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'role'  => 'required|in:super_user,kepsek,tu,keuangan,bkk',
        ]);

        Admin::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'password' => Hash::make('password'), // default
            'foto' => 'default.jpg',
            'role'     => $data['role'],
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success','User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = Admin::findOrFail($id);
        $data = $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,'.$user->id,
            'role'  => 'required|in:super_user,kepsek,tu,keuangan,bkk',
        ]);

        $user->update([
            'nama'  => $data['nama'],
            'email' => $data['email'],
            'role'  => $data['role'],
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success','User berhasil diperbarui.');
    }

    public function resetPassword($id)
    {
        $user = Admin::findOrFail($id);
        $user->password = Hash::make('password');
        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success','Password di-reset ke default.');
    }

    public function destroy($id)
    {
        $user = Admin::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success','User berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
    
        Excel::import(new UserImport, $request->file('file'));
    
        return redirect()->route('admin.users.index')
                         ->with('success','Data user berhasil diimpor.');
    }
}
