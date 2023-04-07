<?php

namespace Notabenedev\SiteAlbums\Events;

use App\AlbumTag;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlbumTagChangePosition
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $tag;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AlbumTag $tag)
    {
        $this->tag = $tag;
    }

}
