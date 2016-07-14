<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleAuthProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->publishes([
          __DIR__.("/config/services.php")=> config_path("/config/services.php"),
          
      ]);
      
        $this->publishes([
          __DIR__.("/Auth/GoogleController.php")=> app_path("/Http/Controllers/Auth/GoogleController.php"),
          
      ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
