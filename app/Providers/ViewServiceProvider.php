<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Share satu baris setting pertama ke semua view
        View::composer('*', function ($view) {
            $setting = Setting::first(); // atau Setting::find(1)
            $view->with('setting', $setting);
        });
    }
}
