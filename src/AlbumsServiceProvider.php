<?php

namespace Notabenedev\SiteAlbums;

use App\AlbumTag;
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

        //Подключаем роуты
        if (config("site-albums.albumTagAdminRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/admin/album-tag.php");
        }

        // Подключение шаблонов.
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'site-albums');

        // Подключение метатегов.
        $seo = app()->config["seo-integration.models"];
        $seo["album-tags"] = AlbumTag::class;
        app()->config["seo-integration.models"] = $seo;

    }
}
