<?php

namespace Notabenedev\SiteAlbums\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;
use PortedCheese\SeoIntegration\Traits\ShouldMetas;

class AlbumTag extends Model
{
    use HasFactory;
    use ShouldMetas, ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "description",
    ];

    protected $metaKey = "album_tags";

    protected static function booting() {

        parent::booting();
    }

}
