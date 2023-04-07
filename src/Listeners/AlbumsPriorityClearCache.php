<?php

namespace Notabenedev\SiteAlbums\Listeners;

use Illuminate\Support\Facades\Cache;
use Notabenedev\SiteAlbums\Facades\AlbumTagActions;
use Notabenedev\SiteAlbums\Models\Album;
use PortedCheese\BaseSettings\Events\PriorityUpdate;

class AlbumsPriorityClearCache
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
    public function handle(PriorityUpdate $event)
    {

        if ($event->table == "albums") {
            $ids = $event->ids;
            if (! empty($ids)) {
                $albums = Album::query()->whereIn("id", $ids)->get();
                foreach ($albums as $album){
                    $album->forgetCache();
                    $tags = $album->tags;
                    foreach ($tags as $tag){
                        // Очистить id альбомов
                        AlbumTagActions::forgetAlbumsIds($tag);
                    }
                }
            }
        }
        Cache::forget("albums-getAll");
    }
}
