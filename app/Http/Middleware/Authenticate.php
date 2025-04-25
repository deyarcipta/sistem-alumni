<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Cek apakah guard yang digunakan adalah admin atau alumni
        // if (!$request->expectsJson()) {
        //     // Cek untuk guard admin
        //     if ($request->is('admin') || $request->is('admin/*')) {
        //         return route('admin.login'); // Redirect ke login admin
        //     }
        //     // Cek untuk guard alumni
        //     if (
        //         $request->is('') || 
        //         $request->is('alumni') || 
        //         $request->is('legalisir') || 
        //         $request->is('daftar-perusahaan') || 
        //         $request->is('buku-wisuda') ||
        //         $request->is('loker') || 
        //         $request->is('dokumen-alumni') ||
        //         $request->is('sertifikat-alumni') ||
        //         $request->is('alumni') ||
        //         $request->is('/*')
        //         ) {
        //         return route('alumni.login'); // Redirect ke login alumni
        //     }
        // }

        if (!$request->expectsJson()) {
            // Jika URL diawali dengan /admin maka redirect ke login admin
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // Selain itu, redirect ke login alumni
            return route('alumni.login');
        }

        return null; // Jika tidak ada yang sesuai, default akan mengarah ke login
    }
}
