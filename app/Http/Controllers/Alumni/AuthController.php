<?php

// app/Http/Controllers/Alumni/AuthController.php
namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('alumni.pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('nis', 'password');
        if (Auth::guard('alumni')->attempt($credentials)) {
            return redirect()->route('alumni.dashboard.index');
        }
        return back()->withErrors(['nis' => 'Login gagal']);
    }

    public function logout()
    {
        Auth::guard('alumni')->logout();
        return redirect()->route('alumni.login');
    }
}
