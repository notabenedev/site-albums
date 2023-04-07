<?php

namespace Notabenedev\SiteAlbums\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use PortedCheese\BaseSettings\Traits\ShouldGallery;
use PortedCheese\BaseSettings\Traits\ShouldImage;
use PortedCheese\BaseSettings\Traits\ShouldSlug;
use PortedCheese\SeoIntegration\Traits\ShouldMetas;

class Album extends Model
{
    use ShouldSlug, ShouldImage, ShouldGallery, HasFactory, ShouldMetas;

    const COVER_PATH = "albums";

    protected $fillable = [
        "title",
        "slug",
        "description",
        "priority",
    ];

    protected $metaKey = "albums";

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            $maxWeight = self::query()
                ->select("priority", "id")
                ->max("priority");

            $model->priority = $maxWeight + 1;
        });
    }

    /**
     * Теги альбома.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(\App\AlbumTag::class)
            ->withTimestamps();
    }

    /**
     * Данные для тизера.
     *
     * @return mixed
     */
    public function getTeaserData()
    {
        $key = "albumTeaserData:{$this->id}";
        $id = $this->id;
        return Cache::rememberForever($key, function () use ($id) {
            return \App\Album::query()
                ->where("id", $id)
                ->first();
        });
    }

    /**
     * Очистить кэш.
     */
    public function clearCache()
    {
        Cache::forget("albumTeaserData:{$this->id}");
    }
}
