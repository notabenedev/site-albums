<?php

namespace Notabenedev\SiteAlbums;

use Illuminate\Support\ServiceProvider;
use Notabenedev\SiteAlbums\Console\Commands\AlbumsMakeCommand;


class AlbumsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/site-albums.php', 'site-albums'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Публикация конфигурации
        $this->publishes([
            __DIR__.'/config/site-albums.php' => config_path('site-albums.php')
        ], 'config');

        // Подключение миграции
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Console
        if ($this->app->runningInConsole()){
            $this->commands([
                AlbumsMakeCommand::class,
            ]);
        }
    }
}
