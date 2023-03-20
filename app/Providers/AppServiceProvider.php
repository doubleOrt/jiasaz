<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
      $WEBSITE_LOGO_IMAGE_PATH = "images/icon/logo.png";
		  Schema::defaultStringLength(125);
		  View::share('WEBSITE_LOGO_IMAGE_PATH', $WEBSITE_LOGO_IMAGE_PATH);
    }
}
