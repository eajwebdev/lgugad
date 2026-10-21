<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // The master layout (logo, system name) needs the settings row on every page.
        View::composer(['layouts.master', 'settings.system_name'], function ($view) {
            $view->with('setting', Setting::current());
        });
    }
}
