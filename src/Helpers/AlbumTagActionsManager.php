<?php

namespace Notabenedev\SiteAlbums\Helpers;

use App\AlbumTag;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class AlbumTagActionsManager
{

    /**
     * Список всех тегов.
     *
     * @return array
     */
    public function getAllList()
    {
        $tags = [];
        foreach (AlbumTag::all()->sortBy("title") as $item) {
            $tags[$item->id] = "$item->title ({$item->slug})";
        }
        return $tags;
    }


    /**
     * Admin breadcrumbs
     *
     * @param AlbumTag $tag
     * @param bool $isAlbumPage
     * @return array
     *
     */
    public function getAdminBreadcrumb(AlbumTag $tag, bool $isAlbumPage = false)
    {
        $breadcrumb = [];

        $breadcrumb[] = (object) [
            "title" => config("site-albums.sitePackageName")." - ". config("site-albums.siteAlbumTagName"),
            "url" => route("admin.album-tags.index"),
            "active" => false,
        ];

        $routeParams = Route::current()->parameters();
        $isAlbumPage = $isAlbumPage && ! empty($routeParams["album"]);
        $active = ! empty($routeParams["tag"]) &&
            $routeParams["tag"]->id == $tag->id &&
            ! $isAlbumPage;
        $breadcrumb[] = (object) [
            "title" => $tag->title,
            "url" => route("admin.album-tags.show", ["tag" => $tag]),
            "active" => $active,
        ];
        if ($isAlbumPage) {
            $album = $routeParams["album"];
            $breadcrumb[] = (object) [
                "title" => $album->title,
                "url" => route("admin.albums.show", ["album" => $album]),
                "active" => true,
            ];
        }
        return $breadcrumb;
    }

    /**
     * Хлебные крошки для сайта.
     *
     * @param AlbumTag $tag
     * @return array
     */
    public function getSiteBreadcrumb(AlbumTag $tag)
    {
        $breadcrumb = null;

        return $breadcrumb;
    }


    /**
     * Получить альбомы по тегу
     *
     * @param int $albumTagId
     * @return mixed
     */
    public function getAlbumsIds($albumTagId)
    {
        $tag =AlbumTag::query()->where("id","=",$albumTagId)->first();
        $key = "album-tag-actions-getAlbums:{$tag->id}";
        return Cache::rememberForever($key, function() use ($tag) {
            $albums = $tag->albums;
            $items = [];
            foreach ($albums as $key => $item) {
                $items[$item->id] = $item;
            }
            return $items;
        });
    }

    /**
     * Очистить кэш идентификаторов альбомов.
     *
     * @param AlbumTag $tag
     */
    public function forgetAlbumsIds(AlbumTag $tag)
    {
        $keys = ["album-tag-actions-getAlbums:{$tag->id}"];
        foreach ($keys as $key){
            Cache::forget("$key");
        }
    }
}