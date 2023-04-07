<?php
return [
    "sitePackageName" => "Галерея",
    "siteAlbumTagName" => "Теги",
    "siteAlbumName" => "Альбомы",

    "albumsSiteUrlName" => "gallery",
    "albumUrlName" => "album",
    "albumTagUrlName" => "tag",

    "siteBreadcrumb" => true,

    "albumTagAdminRoutes" => true,
    "albumTagSiteRoutes" => true,

    "albumTagFacade" => \Notabenedev\SiteAlbums\Helpers\AlbumTagActionsManager::class,

];