<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumni;
use App\Models\Admin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Untuk alumni layout
        View::composer('alumni.layouts.topbar', function ($view) {
            $user = Auth::guard('alumni')->user();
            $alumni = null;

            if ($user) {
                $alumni = Alumni::where('id_alumni', $user->id_alumni)->first();
            }

            $view->with('alumni', $alumni);
        });

        // Untuk admin layout
        View::composer('admin.layouts.topbar', function ($view) {
            $user = Auth::guard('admin')->user();
            $admin = null;

            if ($user) {
                $admin = Admin::where('id', $user->id)->first();
            }

            $view->with('admin', $admin);
        });
    }
}
