<?php

namespace Notabenedev\SiteAlbums\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Notabenedev\SiteAlbums\Facades\AlbumTagActions;
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
        "person",
        "accent",
        "info",
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
     * Есть ли тег у альбома
     *
     * @param $id
     * @return mixed
     */

    public function hasTag($id)
    {
        return $this->tags->where('id',$id)->count();
    }

    /**
     * Обновить Теги
     *
     * @param $userInput
     */
    public function updateTags($userInput)
    {
        $tagIds = [];
        foreach ($userInput as $key => $value) {
            if (strstr($key, "check-") == false) {
                continue;
            }
            $tagIds[] = $value;
        }
        $this->tags()->sync($tagIds);
        $this->clearCache();
    }

    /**
     * Change publish status
     *
     */
    public function publish()
    {
        $this->published_at = $this->published_at  ? null : now();
        $this->save();
    }

    /**
     * Изменить дату создания.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return datehelper()->changeTz($value);
    }

    /**
     * Изменить дату публикации.
     *
     * @param $value
     * @return string
     */
    public function getPublishedAtAttribute($value)
    {
        return datehelper()->changeTz($value);
    }

    /**
     * Данные для тизера.
     *
     * @return mixed
     */
    public function getTeaserData($grid = 3)
    {
        $key = "album-teaser:{$this->id}-{$grid}";
        $id = $this->id;
        $model = $this;
        $album =  Cache::rememberForever($key, function () use ($model) {
            $image = $model->image;
            $tags = $model->tags;
            $images = $model->images->sortBy('weight');
            return $model;
        });

        $view = view("site-albums::site.albums.teaser", [
            'album' => $album,
            'grid' => $grid,
        ]);
        return $view->render();

    }

    /**
     * Очистить кэш.
     */
    public function clearCache()
    {
        foreach ($this->tags as $tag){
            AlbumTagActions::forgetAlbumsIds($tag);
        }

        Cache::forget("album-teaser:{$this->id}-3");
        Cache::forget("album-teaser:{$this->id}-4");

        Cache::forget("albums-get-all-published");
    }

    public static function getAllPublished()
    {
        $key = "albums-get-all-published";
        return Cache::rememberForever($key, function()  {
            $items = [];
            $albums = \App\Album::query()->whereNotNull("published_at")->orderBy("priority");
            foreach ($albums as $item) {
                $items[$item->id] = $item;
            }
            return $items;
        });
    }

}
