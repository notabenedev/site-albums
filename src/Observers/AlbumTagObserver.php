<?php

namespace Notabenedev\SiteAlbums\Observers;

use App\AlbumTag;
use Notabenedev\SiteAlbums\Events\AlbumTagChangePosition;
use PortedCheese\BaseSettings\Exceptions\PreventDeleteException;

class AlbumTagObserver
{

    /**
     * Перед сохранением
     *
     * @param AlbumTag $tag
     */
    public function creating(AlbumTag $tag){
        $max = AlbumTag::query()
                ->max("priority");
        $tag->priority = $max +1;
    }

    /**
     * После создания.
     *
     * @param AlbumTag $tag
     */
    public function created(AlbumTag $tag)
    {
        event(new AlbumTagChangePosition($tag));
    }


    /**
     * После обновления.
     *
     * @param AlbumTag $tag
     */
    public function updated(AlbumTag $tag)
    {
        event(new AlbumTagChangePosition($tag));

    }

    /**
     * Перед удалением
     *
     * @param AlbumTag $tag
     * @throws PreventDeleteException
     */
    public function deleting(AlbumTag $tag){
        if ($tag->albums->count()){
            throw new PreventDeleteException("Невозможно удалить тег, у него есть альбомы");
        }
    }
}
