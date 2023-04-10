<?php

namespace Notabenedev\SiteAlbums\Listeners;

use App\Album;
use Notabenedev\SiteAlbums\Facades\AlbumTagActions;

class AlbumClearCacheOnUpdateImage
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
    public function handle($event)
    {
        $morph = $event->morph;
        if (!empty($morph) && get_class($morph) == Album::class) {
            $morph->clearCache();
            $tags = $morph->tags;
            foreach ($tags as $tag){
                // Очистить id альбомов
                AlbumTagActions::forgetAlbumsIds($tag);
            }
        }
    }
}
