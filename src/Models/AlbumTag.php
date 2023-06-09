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

    protected $metaKey = "album-tags";

    protected static function booting() {

        parent::booting();
    }

    /**
     * Альбомы по тегу
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function albums()
    {
        return $this->belongsToMany(\App\Album::class)->orderBy("priority")
            ->withTimestamps();
    }

    /**
     * Model's tree
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     *
     */
    public static function getAll(){
        $query = self::query();
        return $query
            ->orderBy("priority")
            ->get();
    }
}
