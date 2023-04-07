<?php

namespace Notabenedev\SiteAlbums;

use App\AlbumTag;
use App\Observers\Vendor\SiteAlbums\AlbumTagObserver;
use Illuminate\Support\ServiceProvider;
use Notabenedev\SiteAlbums\Console\Commands\AlbumsMakeCommand;
use Notabenedev\SiteAlbums\Events\AlbumTagChangePosition;
use Notabenedev\SiteAlbums\Listeners\AlbumClearCacheOnUpdateImage;
use Notabenedev\SiteAlbums\Listeners\AlbumsPriorityClearCache;
use Notabenedev\SiteAlbums\Listeners\AlbumTagIdsInfoClearCache;
use PortedCheese\BaseSettings\Events\ImageUpdate;
use PortedCheese\BaseSettings\Events\PriorityUpdate;


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

        $this->initFacades();
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
        $seo["albums"] = Album::class;
        app()->config["seo-integration.models"] = $seo;

        // Events
        $this->addEvents();

        // Наблюдатели.
        $this->addObservers();

    }

    /**
     * Добавление наблюдателей.
     */
    protected function addObservers()
    {
        if (class_exists(AlbumTagObserver::class) && class_exists(AlbumTag::class)) {
            AlbumTag::observe(AlbumTagObserver::class);
        }
    }

    /**
     * Подключение Events.
     */

    protected function addEvents()
    {
        // Изменение позиции тега.
        $this->app["events"]->listen(AlbumTagChangePosition::class, AlbumTagIdsInfoClearCache::class);
        // Подписаться на обновление изображений.
         $this->app['events']->listen(ImageUpdate::class, AlbumClearCacheOnUpdateImage::class);
        // Подписаться на изменения приоритета альбома
         $this->app['events']->listen(PriorityUpdate::class, AlbumsPriorityClearCache::class);
    }

    /**
     * Подключение Facade.
     */
    protected function initFacades()
    {
        $this->app->singleton("album-tag-actions", function () {
            $class = config("site-albums.albumTagFacade");
            return new $class;
        });
    }
}
