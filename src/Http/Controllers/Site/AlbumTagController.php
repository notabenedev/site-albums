<?php

namespace Notabenedev\SiteAlbums\Http\Controllers\Site;

use App\Album;
use App\AlbumTag;
use App\Http\Controllers\Controller;
use App\Meta;
use Notabenedev\SiteAlbums\Facades\AlbumTagActions;

class AlbumTagController extends Controller
{

    public function show(AlbumTag $tag){

        $siteBreadcrumb = null;

        if (config("site-albums.siteBreadcrumb")){
            $siteBreadcrumb =  AlbumTagActions::getSiteBreadcrumb($tag, null);
        }

        $pageMetas = Meta::getByModelKey($tag);

        $grid = Album::grid(config("site-albums.siteAlbumsGrid", 3));

        return  view("site-albums::site.album-tags.show", [
                "tag" => $tag,
                "grid" => $grid,
                "siteBreadcrumb" => $siteBreadcrumb,
                "pageMetas" => $pageMetas,
            ]);
    }

}
