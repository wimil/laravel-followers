<?php
namespace Wimil\Followers;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Wimil\Followers\Helpers\Follow;

class Provider extends BaseProvider
{

    public function boot()
    {
        //publicar configraciion
        $this->publishes([
            __DIR__ . '/../config/followers.php' => config_path('followers.php'),
        ], 'config');

        //publicar migraciones
        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../migrations/create_followers_table.php' => database_path("migrations/{$timestamp}_create_followers_table.php"),
        ], 'migrations');

    }

    public function register()
    {
        //combinar configuracion de usuario y packete
        $this->mergeConfigFrom(
            __DIR__ . '/../config/followers.php',
            'followers'
        );

        $this->app->bind('follow', function () {
            return new Follow();
        });
    }
}
