<?php

// app/Http/Controllers/Admin/AuthController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard.index');
        }
        return back()->withErrors(['email' => 'Login gagal']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.dashboard.index');
    }
}
