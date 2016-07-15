<?php

namespace   AuthGoogle;

use Illuminate\Support\ServiceProvider;

use Storage;

class GoogleAuthProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
      
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
        $this->mergeConfigFrom(
            __DIR__.'/config/filesystems.php', 'filesystems.disks'
        );

        $this->mergeConfigFrom(
            __DIR__.'/config/services.php', 'services'
        );
    }
}
