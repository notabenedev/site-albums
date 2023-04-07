<?php

namespace Notabenedev\SiteAlbums\Listeners;

use Illuminate\Support\Facades\Cache;
use Notabenedev\SiteAlbums\Events\AlbumTagChangePosition;
use Notabenedev\SiteAlbums\Facades\AlbumTagActions;

class AlbumTagIdsInfoClearCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AlbumTagChangePosition $event)
    {
        $tag = $event->tag;
        // Очистить id альбомов
        AlbumTagActions::forgetAlbumsIds($tag);
        Cache::forget("albums-getAll");
    }
}
