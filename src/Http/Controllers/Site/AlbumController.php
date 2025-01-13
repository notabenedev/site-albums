<?php

namespace Notabenedev\SiteAlbums\Http\Controllers\Site;

use App\Album;
use App\AlbumTag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Notabenedev\SiteAlbums\Facades\AlbumTagActions;
use PortedCheese\SeoIntegration\Models\Meta;

class AlbumController extends Controller
{
    const PAGER = 18;
    public function index( Request $request)
    {
        $siteBreadcrumb = null;

        if (config("site-albums.siteBreadcrumb")){
            $siteBreadcrumb = [
                (object) [
                    'active' => true,
                    'url' => route("site.albums.index"),
                    'title' => config("site-albums.sitePackageName"),
                ]
            ];
        }

        $grid = Album::grid(config("site-albums.siteAlbumsGrid", 3));
        $albums = Album::query()->whereNotNull("published_at")->orderBy("priority")
            ->paginate(self::PAGER)
            ->appends($request->input());
        return  view("site-albums::site.albums.index", [
            "albums" => $albums,
            "grid" => $grid,
            "siteBreadcrumb" => $siteBreadcrumb,
            "pageMetas" => Meta::getByPageKey(config("site-albums.albumsSiteUrlName")),
        ]);
    }

    public function show(Album $album){

        $siteBreadcrumb = null;
        if ($album->published_at) {

        if (config("site-albums.siteBreadcrumb")){
            $siteBreadcrumb =  AlbumTagActions::getSiteBreadcrumb(null, $album);
        }

        $grid = Album::grid(config("site-albums.siteAlbumGalleryGrid", 3));

        $pageMetas = \App\Meta::getByModelKey($album);

        return  view("site-albums::site.albums.show", [
                "album" => $album,
                "grid" => $grid,
                "gallery" => $album->images->sortBy('weight'),
                "image" => $album->image,
                "siteBreadcrumb" => $siteBreadcrumb,
                "pageMetas" => $pageMetas,
            ]);
        }
        else
            return redirect(route("site.albums.index"));
    }

}
