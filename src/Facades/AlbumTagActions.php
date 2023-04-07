<?php

namespace Notabenedev\SiteAlbums\Facades;

use App\AlbumTag;
use Illuminate\Support\Facades\Facade;
use Notabenedev\SiteAlbums\Helpers\AlbumTagActionsManager;

/**
 *
 * Class StaffDepartmentActions
 * @package Notabenedev\SiteStaff\Facades
 * @method static array getAllList()
 * @method static array getAdminBreadcrumb(AlbumTag $tag, $isAlbumPage = false)
 * @method static array getSiteBreadcrumb(AlbumTag $tag)
 * @method static mixed getAlbumsIds(int $albumTagId)
 * @method static forgetAlbumsIds(AlbumTag $tag)
 */
class AlbumTagActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "album-tag-actions";
    }
}